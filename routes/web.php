<?php

Route::get('/', 'PagesController@root')->name('root');
Route::get('tos', 'PagesController@tos')->name('tos');
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('home', 'PagesController@home')->name('home');

    Route::get('verification/notice', 'VerificationController@notice')->name('verification.notice');
    Route::get('verification/verify', 'VerificationController@verify')->name('verification.verify');
    Route::get('verification/send', 'VerificationController@send')->name('verification.send');

    Route::get('user/profile', 'UsersController@profile')->name('user.profile');
    Route::post('user/profile', 'UsersController@update')->middleware('csrf');
});

Route::middleware('verified')->group(function () {
    Route::get('user/recharge', 'UsersController@recharge')->name('user.recharge');

    Route::post('payment/online', 'PaymentController@online')->middleware('csrf')->name('payment.online');
    Route::post('payment/redeem', 'PaymentController@redeem')->middleware('csrf')->name('payment.redeem');

    Route::get('plans', 'PlansController@root')->name('plans.root');
    Route::get('plans/{plan}', 'PlansController@show')->name('plans.show');
    Route::post('plans/{plan}/confirm', 'PlansController@confirm')->middleware('csrf')->name('plans.confirm');
    Route::post('plans/{plan}/buy', 'PlansController@buy')->middleware('csrf')->name('plans.buy');

    Route::get('services', 'ServicesController@root')->name('services.root');
    Route::get('services/{service}', 'ServicesController@show')->name('services.show');
    Route::post('services/{service}', 'ServicesController@save')->middleware('csrf');
    Route::post('services/{service}/renew', 'ServicesController@renew')->middleware('csrf')->name('services.renew');
    Route::post('services/{service}/renew/confirm', 'ServicesController@renewConfirm')->middleware('csrf')->name('services.renew.confirm');
    Route::get('services/{service}/traffic_logs', 'ServicesController@logs')->name('services.logs');
    Route::get('services/{service}/reset', 'ServicesController@reset')->name('services.reset');
    Route::get('services/{service}/{node}/qrcode', 'ServicesController@qrcode')->name('services.node.qrcode');
    Route::post('services/{service}/package', 'ServicesController@package')->middleware('csrf')->name('services.package');
    Route::post('services/{service}/plan', 'ServicesController@plan')->middleware('csrf')->name('services.plan');
});

Route::get('services/{service}/subscription', 'ServicesController@subscription')->name('services.subscription');

Route::post('payment/notify', 'PaymentController@notify')->name('payment.notify');
