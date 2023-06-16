<?php

use App\Http\Controllers\Ajax\Admin\LandingController;
use Illuminate\Support\Facades\Route;

Route::post('landing/set-entity', [LandingController::class,'setEntity'])->name('ajax.landing.set_entity');