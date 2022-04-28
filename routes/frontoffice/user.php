<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('user/details','UserController@details');
    Route::get('user/logout','UserController@details');
});
