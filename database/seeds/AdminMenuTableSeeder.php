<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '首页',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 00:36:23',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 14,
                'title' => '面板配置',
                'icon' => 'fa-tasks',
                'uri' => NULL,
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 15,
                'title' => '管理员',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 16,
                'title' => '角色',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 17,
                'title' => '权限',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 18,
                'title' => '菜单',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 19,
                'title' => '操作日志',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-11-12 14:15:17',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 13,
                'title' => '系统日志',
                'icon' => 'fa-exclamation-triangle',
                'uri' => '/logs',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:37:56',
                'updated_at' => '2018-11-12 14:15:17',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 2,
                'title' => '用户',
                'icon' => 'fa-users',
                'uri' => '/users',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:38:14',
                'updated_at' => '2018-11-12 00:39:40',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 3,
                'title' => '节点',
                'icon' => 'fa-circle-o',
                'uri' => '/nodes',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:38:55',
                'updated_at' => '2018-11-12 00:39:40',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 4,
                'title' => '套餐',
                'icon' => 'fa-archive',
                'uri' => '/plans',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:39:13',
                'updated_at' => '2018-11-12 00:39:40',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 5,
                'title' => '服务',
                'icon' => 'fa-briefcase',
                'uri' => '/services',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:39:32',
                'updated_at' => '2018-11-12 00:39:40',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 6,
                'title' => '兑换码',
                'icon' => 'fa-bookmark',
                'uri' => '/redeem_codes',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:40:15',
                'updated_at' => '2018-11-12 00:41:19',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 0,
                'order' => 7,
                'title' => '优惠券',
                'icon' => 'fa-bookmark-o',
                'uri' => '/coupon_codes',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:40:49',
                'updated_at' => '2018-11-12 00:41:19',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'order' => 9,
                'title' => '文章',
                'icon' => 'fa-book',
                'uri' => '/posts',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:41:11',
                'updated_at' => '2018-11-12 14:15:17',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 10,
                'title' => '交易记录',
                'icon' => 'fa-credit-card',
                'uri' => '/payment_logs',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:41:58',
                'updated_at' => '2018-11-12 14:15:17',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 0,
                'order' => 11,
                'title' => '流量记录',
                'icon' => 'fa-adjust',
                'uri' => '/traffic_logs',
                'permission' => NULL,
                'created_at' => '2018-11-12 00:42:12',
                'updated_at' => '2018-11-12 14:15:17',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 0,
                'order' => 8,
                'title' => '邀请码',
                'icon' => 'fa-at',
                'uri' => '/invite_codes',
                'permission' => NULL,
                'created_at' => '2018-11-12 14:14:15',
                'updated_at' => '2018-11-12 14:15:17',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 0,
                'order' => 12,
                'title' => '邀请记录',
                'icon' => 'fa-code-fork',
                'uri' => '/invite_logs',
                'permission' => NULL,
                'created_at' => '2018-11-12 14:14:59',
                'updated_at' => '2018-11-12 14:15:17',
            ),
        ));
        
        
    }
}