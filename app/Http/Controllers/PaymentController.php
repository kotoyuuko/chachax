<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

        $result = app('youzan')->get('youzan.pay.qrcode.create', [
            'qr_type' => 'QR_TYPE_DYNAMIC',
            'qr_price' => $payment->amount * 100,
            'qr_name' => '为 ' . $request->user()->name . ' 充值 ' . $request->amount . ' 元',
            'qr_source' => $payment->id,
        ]);
        $response = $result['response'];

        $payment->payment_id = $response['qr_id'];
        $payment->save();

        $agent = new Agent();
        if ($agent->isPhone()) {
            return redirect()->to($response['qr_url']);
        } else {
            return view('payment.qrcode')
                ->with('qrcode', $response['qr_code']);
        }
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
}
