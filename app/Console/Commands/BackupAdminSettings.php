<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupAdminSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup ChaChaX Admin Settings';

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
        $tables = [
            'admin_menu',
            'admin_permissions',
            'admin_role_menu',
            'admin_role_permissions',
            'admin_role_users',
            'admin_roles',
            'admin_user_permissions',
            'admin_users',
        ];
        
        $this->call('iseed', [implode(',', $tables)]);
    }
}
