<?php

Route::get('/', 'PagesController@root')->name('root');
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('verification/notice', 'VerificationController@notice')->name('verification.notice');
    Route::get('verification/verify', 'VerificationController@verify')->name('verification.verify');
    Route::get('verification/send', 'VerificationController@send')->name('verification.send');
});

Route::middleware('verified')->group(function () {
});
