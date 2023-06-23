<?php

use App\Http\Controllers\Features\Action\InfoController;
use App\Http\Controllers\Features\UserInfoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// ensure entity already Defined
Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::get('info', [InfoController::class, 'index'])->name('info');
        Route::get('products')->name('products');
        Route::get('products/{product}')->name('products.show');
        Route::get('carts')->name('carts');

        Route::get('profile', [UserInfoController::class, 'profile'])->name('user.profile');
    });

    Route::post('users',[UserController::class,'register'])->middleware("guest");
});
