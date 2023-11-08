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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/make_token', [\App\Http\Controllers\API\V1\TokenController::class, 'store']);

Route::group(['middleware' => [\App\Http\Middleware\delivery::class]], function () {
    Route::get('orders', [\App\Http\Controllers\API\V1\OrderController::class , 'index']);
    Route::post('accept_order', [\App\Http\Controllers\API\V1\OrderController::class , 'accept_order']);
    Route::post('accept_order', [\App\Http\Controllers\API\V1\OrderController::class , 'complete_order']);
});
Route::group(['middleware' => [\App\Http\Middleware\company::class]], function () {
    Route::post('/store', [\App\Http\Controllers\API\V1\OrderController::class, 'store']);
    Route::post('/show_status', [\App\Http\Controllers\API\V1\OrderController::class , 'show']);
    Route::post('/cancel_order', [\App\Http\Controllers\API\V1\OrderController::class , 'cancel_order']);
});
