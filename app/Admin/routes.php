<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('users', 'UsersController');
    $router->resource('redeem_codes', 'RedeemCodesController');
    $router->resource('nodes', 'NodesController');
    $router->resource('plans', 'PlansController');
    $router->resource('services', 'ServicesController');
    $router->resource('payment_logs', 'PaymentLogsController');
    $router->resource('posts', 'PostsController');
    $router->resource('traffic_logs', 'TrafficLogsController');
    $router->resource('coupon_codes', 'CouponCodesController');
    $router->resource('invite_codes', 'InviteCodesController');
    $router->resource('invite_logs', 'InviteLogsController');
    $router->resource('packages', 'PackagesController');
});
