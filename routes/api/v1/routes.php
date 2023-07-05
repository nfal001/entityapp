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
        Route::put('carts',[CartController::class,'updateCart'])->name('carts.store');
        Route::delete('carts',[CartController::class,'store'])->name('carts.destroy');

        Route::get('checkout',[TransactionController::class,'commit'])->name('checkout');

        Route::get('transactions',[TransactionController::class,'userIndex'])->name('user.transactions');
        
        Route::apiResource('addresses',AddressController::class);
        
        Route::get('profile', [UserInfoController::class, 'profile'])->name('user.profile');
        Route::get('addresses', [AddressController::class, 'index'])->name('user.addresses');
    });

    
    Route::prefix('geo')->as('geo.')->group(function () {
        Route::get('/provinces',[ProvinceController::class,'index'])->name('provinces.all');
        Route::get('/provinces/{province}/cities',[CityController::class,'index'])->name('provinces.cities.all');
        Route::get('/provinces/{province}/cities/{city}/districts',[DistrictController::class,'index'])->name('provinces.cities.districts.all');
    });

    Route::post('users',[UserController::class,'register'])->middleware("guest")->name('users.register');

    // 'checkout' - from cart -> transaction
    // '/transactions' C-R
    // '/transactions/{id_onlyAuthenticatedUser}' R
    // '/carts' C-R : Create - add new entity into current active cart
    // '/carts/{id_onlyAuthenticatedUser}' R
    // '/addresses' C-R-U-D
    // '/addresses/{id_onlyAuthenticatedUser}' R
    // '/'

    /**
     * 
     * transactions: authorized_responsibleUserAndAdmin
     * address: authorized_responsibleUserAndAdmin
     * 
     * carts: 
     * insert into active carts - store function
     * delete item by id from active carts - destroy function
     * if carts item === 1
     * carts userID x where cart_transaction_status pending, 
     * cart_transaction_status [active,pending],
     * make sure each user has only one pending carts ; 
     * list item in table entity_cart (queue)
     * 
     * carts can only delete 1 item?
     */
});
