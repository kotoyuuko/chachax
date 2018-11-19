<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Service;
use Illuminate\Console\Command;

class DeleteExpiredServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired services';

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
        $services = Service::where('expired_at', '<', Carbon::now())->get();

        foreach ($services as $service) {
            \Log::info("Service deleted.", [
                'id' => $service->id
            ]);

            $service->delete();
        }
    }
}
