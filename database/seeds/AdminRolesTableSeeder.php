<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '管理员',
                'slug' => 'administrator',
                'created_at' => '2018-11-11 22:26:45',
                'updated_at' => '2018-11-12 00:44:18',
            ),
        ));
        
        
    }
}