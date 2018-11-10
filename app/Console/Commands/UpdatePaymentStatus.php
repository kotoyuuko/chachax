<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PaymentLog;
use Illuminate\Console\Command;

class UpdatePaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update payments status';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $payments = PaymentLog::where('paid_at', null)
            ->where('payment', 'youzan')
            ->get();

        foreach ($payments as $payment) {
            $result = app('youzan')->get('youzan.trades.qr.get', [
                'qr_id' => $payment->payment_id,
                'status' => 'TRADE_RECEIVED'
            ]);
            $response = $result['response'];
            
            if ($response['total_results'] > 0) {
                $payment->paid_at = Carbon::now();
                $payment->save();

                $user = User::find($payment->user_id);
                $user->balance += $payment->amount;
                $user->save();
            }
        }
    }
}
