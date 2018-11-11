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
    Route::post('user/profile', 'UsersController@update');
});

Route::middleware('verified')->group(function () {
    Route::get('user/recharge', 'UsersController@recharge')->name('user.recharge');

    Route::post('payment/online', 'PaymentController@online')->name('payment.online');
    Route::post('payment/redeem', 'PaymentController@redeem')->name('payment.redeem');

    Route::get('plans', 'PlansController@root')->name('plans.root');
    Route::get('plans/{plan}', 'PlansController@show')->name('plans.show');
    Route::post('plans/{plan}/confirm', 'PlansController@confirm')->name('plans.confirm');
    Route::post('plans/{plan}/buy', 'PlansController@buy')->name('plans.buy');

    Route::get('services', 'ServicesController@root')->name('services.root');
    Route::get('services/{service}', 'ServicesController@show')->name('services.show');
    Route::post('services/{service}', 'ServicesController@save');
    Route::post('services/{service}/renew', 'ServicesController@renew')->name('services.renew');
    Route::post('services/{service}/renew/confirm', 'ServicesController@renewConfirm')->name('services.renew.confirm');
    Route::get('services/{service}/traffic_logs', 'ServicesController@logs')->name('services.logs');
});
