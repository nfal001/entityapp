<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

require 'api/v1/routes.php';
require 'api/admin/v1/routes.php'; 


// move this ajax to middleware admin, this pathname need csrf verification, i mean ajax/admin* and ajax/set_entity
Route::middleware(['auth:sanctum'])->get('v1/user', function (Request $request) {
    return $request->user();
});