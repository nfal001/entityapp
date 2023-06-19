<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\Admin\LandingController;
use App\Http\Controllers\Features\EntityController;
use App\Http\Controllers\UserController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('landing/set-entity', [LandingController::class, 'setEntity'])->name('landing.set_entity');

    Route::middleware(['auth:sanctum','abilities:admin', 'entity.is_defined'])->prefix('manage')->as('manage.')->group(function () {
        Route::apiResource('users',UserController::class);

        Route::apiResource('entity',EntityController::class);
        // Route::get('transactions')->name('transaction');
    });
    
});
