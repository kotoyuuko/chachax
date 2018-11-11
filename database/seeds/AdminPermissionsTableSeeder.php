<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '最高权限',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:44:31',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '首页',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:44:40',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '登录',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:44:47',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '用户设置',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:45:04',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '权限管理',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:45:18',
            ),
        ));
        
        
    }
}