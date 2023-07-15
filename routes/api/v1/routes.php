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
