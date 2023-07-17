<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Features\Action\InfoController;
use App\Http\Controllers\Features\AddressController;
use App\Http\Controllers\Features\EntityController;
use App\Http\Controllers\Features\UserInfoController;
use App\Http\Controllers\Geo\CityController;
use App\Http\Controllers\Geo\DistrictController;
use App\Http\Controllers\Geo\ProvinceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// ensure entity already Defined
Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {

    // TODO : Add Rate Limit On Webhook 
    Route::group(['prefix'=>'webhook'], function () {
        
        Route::group(['prefix'=>'payments','as'=>'payments.'],function () {

            /**
             * * Logic:
             * ! Add Middleware to Check User-Agent before going to Controller, 
             * ! if notExist in authorized-payments-ua cache, return 404
             * 
             */
            // TODO: Webhook Handle Payment, 
            // ignore if pending, 
            // if expire, delete payment
            Route::post('notification', [HandlePaymentController::class,'notification'])->name('notification');

            Route::post('recurring', [HandlePaymentController::class,'recurring'])->name('recurring');

            Route::post('unfinished', [HandlePaymentController::class,'unfinished'])->name('unfinished');
            /**
             * ! Expectation for Error Response:
             * {
             *      redirect_url = "FRONTEND_URL/payment/error?order_id=123213?version=1"
             * }
             */
            Route::post('error', [HandlePaymentController::class,'finish'])->name('error');

            /**
             * ! Expectation for Finish Response:
             * {
             *      redirect_url = "FRONTEND_URL/payment/success?order_id=123213?version=1"
             * }
             */
            Route::get('finish', [HandlePaymentController::class,'finishRedirect'])->name('finish.redirectx'); 

        });

    });

    Route::group(["middleware" => "auth:sanctum"], function () {
        Route::get('info', [InfoController::class, 'index'])->name('info');

        Route::get('entities',[EntityController::class,'userIndex'])->name('entities.index');
        Route::get('entities-optional',[EntityController::class,'userIndexOptional'])->name('entities.index.optional');
        Route::get('entities/{entity}',[EntityController::class,'userShow'])->name('entities.show');
        
        Route::get('carts',[CartController::class,'userIndex'])->name('carts');
        Route::post('carts',[CartController::class,'userStore'])->name('carts.store');
        Route::put('carts',[CartController::class,'updateCart'])->name('carts.update');
        // Route::delete('carts',[CartController::class,'store'])->name('carts.destroy');

        Route::post('checkout',[TransactionController::class,'commit'])->name('checkout');

        Route::get('transactions',[TransactionController::class,'userIndex'])->name('user.transactions');
        Route::get('transactions-optional',[TransactionController::class,'userIndexOptional'])->name('user.transactions.index.optional');
        Route::get('transactions/{transaction}',[TransactionController::class,'userShow'])->name('user.transactions.show');
        
        Route::apiResource('addresses',AddressController::class);
        
        Route::get('profile', [UserInfoController::class, 'profile'])->name('user.profile');
        Route::get('addresses', [AddressController::class, 'index'])->name('user.addresses');
        Route::patch('addresses/{address}/select', [AddressController::class, 'selectAddress'])->name('user.addresses.select');

    });

    
    Route::prefix('geo')->as('geo.')->group(function () {
        Route::get('provinces',[ProvinceController::class,'index'])->name('provinces.all');
        Route::get('provinces/{province}/cities',[CityController::class,'index'])->name('provinces.cities.all');
        Route::get('provinces/{province}/cities/{city}/districts',[DistrictController::class,'index'])->name('provinces.cities.districts.all');
    });

    Route::post('users',[UserController::class,'register'])->middleware("guest")->name('users.register');

});