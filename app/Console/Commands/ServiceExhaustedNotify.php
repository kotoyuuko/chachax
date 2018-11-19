<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Console\Command;
use App\Notifications\ServiceExhaustedNotification;

class ServiceExhaustedNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:exhausted_notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send services exhausted notifications';

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
        $services = Service::where('traffic', '<', 512)
            ->where('expired_at', '>', Carbon::now())
            ->get();
        
        foreach ($services as $service) {
            $service->user->notify(new ServiceExhaustedNotification);
        }
    }
}
