<?php

use App\Http\Controllers\Api\OrderItemController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('order_item')->group(function () {
    Route::get('/{nameUser}/{Lastid}', [OrderItemController::class, 'index']);
    Route::post('/insert/{nameUser}/{Lastid}', [OrderItemController::class, 'store']);
    Route::put('/update/{name}/{order_id}/{id}', [OrderItemController::class, 'update']);
    Route::delete('/delete/{name}/{order_id}/{id}', [OrderItemController::class, 'destroy']);
    Route::post('/search/{nameUser}/{order_id}', [OrderItemController::class, 'search']);
    Route::get('/{product_id}', [OrderItemController::class, 'show_max']);
});
