<?php

namespace App\Http\Controllers;

use App\Models\PaymentLog;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Requests\OnlinePaymentRequest;

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
            'description' => '充值 ' . $request->amount . ' 元',
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
}
