<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\Admin\LandingController;
use App\Http\Controllers\Features\EntityController;
use App\Http\Controllers\Geo\CityController;
use App\Http\Controllers\Geo\DistrictController;
use App\Http\Controllers\Geo\ProvinceController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('landing/set-entity', [LandingController::class, 'setEntity'])->name('landing.set_entity');

    Route::middleware(['auth:sanctum','abilities:admin', 'entity.is_defined'])->prefix('manage')->as('manage.')->group(function () {
        Route::apiResource('users',UserController::class);
        Route::apiResource('entity',EntityController::class);
        // Route::get('transactions')->name('transaction');

        Route::prefix('geo')->as('geo.')->group(function () {
            
            Route::get('/provinces',[ProvinceController::class,'index'])->name('provinces.all');
            Route::post('/provinces',[ProvinceController::class,'store'])->name('provinces.store');
            Route::put('/provinces/{province}',[ProvinceController::class,'update'])->name('provinces.update');
            Route::delete('/provinces/{province}',[ProvinceController::class,'destroy'])->name('provinces.destroy');

            Route::get('/provinces/{province}/cities',[CityController::class,'index'])->name('provinces.cities.all');
            Route::post('/provinces/{province}/cities',[CityController::class,'store'])->name('provinces.cities.store');
            Route::delete('/provinces/{province}/cities/{city}',[CityController::class,'destroy'])->name('provinces.cities.destroy');

            Route::get('/provinces/{province}/cities/{city}/districts',[DistrictController::class,'index'])->name('provinces.cities.districts.all');
            Route::post('/provinces/{province}/cities/{city}/districts',[DistrictController::class,'store'])->name('provinces.cities.districts.store');
            Route::delete('/provinces/{province}/cities/{city}/districts/{district}',[DistrictController::class,'destroy'])->name('provinces.cities.districts.destroy');
        });
    });
    
});
