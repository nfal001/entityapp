<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('api/', function () {
    return ['status'=>200,'laravel-version' => app()->version(),'api-latest-version'=>config('app.api_latest')];
});

require __DIR__.'/auth.php';


/**
 * -----------------------------------
 *  * FrontEnd End-Point:
 * -----------------------------------
 * 
 *  TODO : *** admin/landing - entity definition *** 
 *  TODO : admin/login/
 *  TODO : admin/reset-password/ - optional
 *  TODO : admin/dashboard/
 *  TODO : admin/entity/
 *  TODO : admin/order - list, detail,  
 * 
 */