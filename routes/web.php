<?php

Route::get('/', 'PagesController@root')->name('root');
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('verification/notice', 'VerificationController@notice')->name('verification.notice');
    Route::get('verification/verify', 'VerificationController@verify')->name('verification.verify');
    Route::get('verification/send', 'VerificationController@send')->name('verification.send');

    Route::get('user/profile', 'UsersController@profile')->name('user.profile');
    Route::post('user/profile', 'UsersController@update');

    Route::get('user/recharge', 'UsersController@recharge')->name('user.recharge');

    Route::post('payment/online', 'PaymentController@online')->name('payment.online');
    Route::post('payment/redeem', 'PaymentController@redeem')->name('payment.redeem');
});

Route::middleware('verified')->group(function () {
});
