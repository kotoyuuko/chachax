<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Console\Command;
use App\Notifications\ServiceExpiredNotification;

class ServiceExpiredNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:expired_notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send services expired notifications';

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
        $services = Service::where('expired_at', '>', Carbon::now())
            ->where('expired_at', '<', Carbon::parse('+5 days'))
            ->get();
        
        foreach ($services as $service) {
            $service->user->notify(new ServiceExpiredNotification);
        }
    }
}
