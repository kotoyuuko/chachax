<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Console\Command;

class ResetTraffic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'traffic:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset traffic';

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
        $services = Service::where('expired_at', '>', Carbon::now())->get();

        foreach ($services as $service) {
            \Log::info("Resetting service traffic.", [
                'id' => $service->id
            ]);

            $service->traffic = $service->plan->traffic;
            $service->save();
        }
    }
}
