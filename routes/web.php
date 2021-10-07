<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Front_page\CartController;
use App\Http\Controllers\Front_page\HomeController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Front_page\ContactController;
use App\Http\Controllers\Front_page\PaymentController;
use App\Http\Controllers\Front_page\ProductController;
use App\Http\Controllers\Front_page\CheckoutController;
use App\Http\Controllers\Admin\AdminOrderItemController;
use App\Http\Controllers\Front_page\DetailProductController;

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

//user page
Route::get('/', [HomeController::class, 'index']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/product/{category_id}', [ProductController::class, 'category']);
Route::group(['middleware' => 'auth'], function () {
    Route::get('/detail_product/{id}', [DetailProductController::class, 'index']);
    Route::get('/cart/{id}', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'add']);
    Route::get('/checkout/{id}', [CheckoutController::class, 'index']);
    Route::get('/province', [CheckoutController::class, 'get_province']);
    Route::get('/city/{id}', [CheckoutController::class, 'get_city']);
    Route::get('/origin={city_origin}&destination={city_destination}&weight={weight}&courier={courier}', [CheckoutController::class, 'get_ongkir']);
    Route::get('/delete/{order_item_id}', [CartController::class, 'delete']);
    Route::post('/payment', [PaymentController::class, 'index']);
});




// admin page
Auth::routes(['middleware' => 'is_admin']);
Route::get('/admin/', [AdminHomeController::class, 'index']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'middleware' => 'is_admin'], function () {
    Route::get('/', [AdminHomeController::class, 'index']);

    Route::prefix('user')->group(function () {
        Route::get('/', [AdminUserController::class, 'index']);
        Route::get('/insert', [AdminUserController::class, 'insert']);
        Route::post('/insert', [AdminUserController::class, 'insertAction']);
        Route::get('/edit/{id}', [AdminUserController::class, 'edit']);
        Route::post('/edit/{id}', [AdminUserController::class, 'editAction']);
        Route::get('/delete/{id}', [AdminUserController::class, 'delete']);
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [AdminProductController::class, 'index']);
        Route::get('/insert', [AdminProductController::class, 'insert']);
        Route::post('/insert', [AdminProductController::class, 'insertAction']);
        Route::get('/edit/{id}', [AdminProductController::class, 'edit']);
        Route::post('/edit/{id}', [AdminProductController::class, 'editAction']);
        Route::get('/delete/{id}', [AdminProductController::class, 'delete']);
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index']);
        Route::get('/insert', [AdminOrderController::class, 'insert']);
        Route::post('/insert', [AdminOrderController::class, 'insertAction']);
        Route::get('/edit/{id}', [AdminOrderController::class, 'edit']);
        Route::post('/edit/{id}', [AdminOrderController::class, 'editAction']);
        Route::get('/delete/{id}', [AdminOrderController::class, 'delete']);
    });

    Route::prefix('order_item')->group(function () {
        Route::get('/{nameUser}/{Lastid}', [AdminOrderItemController::class, 'index']);
        Route::post('/insert/{nameUser}/{Lastid}', [AdminOrderItemController::class, 'insertAction']);
        Route::get('/edit/{name}/{order_id}/{id}', [AdminOrderItemController::class, 'edit']);
        Route::post('/edit/{name}/{order_id}', [AdminOrderItemController::class, 'editAction']);
        Route::get('/delete/{name}/{order_id}/{id}', [AdminOrderItemController::class, 'delete']);
    });
});
