<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RedeemCode;
use App\Models\PaymentLog;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\OnlinePaymentRequest;
use App\Http\Requests\RedeemPaymentRequest;

class PaymentController extends Controller
{
    public function online(OnlinePaymentRequest $request)
    {
        $payment = PaymentLog::create([
            'user_id' => $request->user()->id,
            'type' => 'recharge',
            'payment' => 'youzan',
            'payment_id' => 0,
            'amount' => $request->amount,
            'description' => '通过在线支付充值 ' . $request->amount . ' 元',
            'paid_at' => null
        ]);

        $data = [
            'appid' => config('eapay.appid'),
            'out_trade_no' => $payment->id,
            'total_fee' => $request->amount,
            'subject' => '账号充值',
            'body' => '为 ' . $request->user()->name . ' 充值 ' . $request->amount . ' 元',
            'show_url' => route('root'),
        ];
        $data['sign'] = eapay_sign($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://api.eapay.cc/v1/order/add');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
        ]);
        $response = curl_exec($ch);

        if (!$response) {
            \Log::error('api.eapay.cc/order/add request error');
            return redirect()
                ->route('user.recharge')
                ->with('danger', '系统错误，请联系管理员！');
        }

        $response = json_decode($response, true);

        if (!$response['status']) {
            \Log::error('api.eapay.cc/order/add create failed: ' . $response['msg']);
            return redirect()
                ->route('user.recharge')
                ->with('danger', '支付接口错误，请联系管理员！');
        }

        $no = $response['data']['no'];
        return redirect()->to('https://api.eapay.cc/v1/order/pay/no/' . $no);
    }

    public function redeem(RedeemPaymentRequest $request)
    {
        $code = RedeemCode::where('code', $request->code)->first();
        $code->usable -= 1;
        $code->save();

        $user = $request->user();
        $user->balance += $code->amount;
        $user->save();

        $payment = PaymentLog::create([
            'user_id' => $user->id,
            'type' => 'recharge',
            'payment' => 'redeem',
            'payment_id' => $code->id,
            'amount' => $code->amount,
            'description' => '使用兑换码充值 ' . $code->amount . ' 元',
            'paid_at' => Carbon::now()
        ]);

        $request->session()
            ->flash('success', '成功使用兑换码 ' . $code->code . ' 充值 ' . $code->amount . ' 元');

        return redirect()->route('user.recharge');
    }

    public function notify(Request $request)
    {
        $data = $request->only([
            'out_trade_no',
            'pay_method',
            'total_fee',
            'trade_no',
        ]);
        $sign = eapay_sign($data);

        if ($sign != $request->sign) {
            return 'FAIL';
        }

        $payment = PaymentLog::find($data['out_trade_no']);

        if (!$payment) {
            return 'FAIL';
        }

        $payment->paid_at = Carbon::now();
        $payment->save();

        $user = User::find($payment->user_id);
        $user->balance += $payment->amount;
        $user->save();

        return 'SUCCESS';
    }
}
