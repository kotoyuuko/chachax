<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => '$2y$10$AArdl6WY7YoWIJ/GqlQumuDUhtB6/rCYhPlYdHSZyxGl7.UvYTw8C',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => NULL,
                'created_at' => '2018-11-11 22:26:45',
                'updated_at' => '2018-11-11 22:26:45',
            ),
        ));
        
        
    }
}