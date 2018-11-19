<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\PaymentLog;
use Illuminate\Console\Command;

class DeleteExpiredPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired payments';

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
        $payments = PaymentLog::where('created_at', '<', Carbon::parse('-30 minutes'))
            ->where('payment', 'youzan')
            ->where('paid_at', null)
            ->get();
        
        foreach ($payments as $payment) {
            \Log::info("Payment deleted.", [
                'id' => $payment->id
            ]);
            
            $payment->delete();
        }
    }
}
