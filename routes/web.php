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
});
