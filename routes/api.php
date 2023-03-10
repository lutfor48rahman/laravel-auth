<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'
    
], function ($router) {

    Route::post('login',[AuthController::class,'login']);
    Route::post('signup',[AuthController::class,'signup']);
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('refresh',[AuthController::class,'refresh']);
    Route::post('me',[AuthController::class,'me']);
    Route::get('/send-verify-mail/{email}',[AuthController::class,'sendVerifyMail']);


});


