<?php
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 管理者
 */
Route::group(['prefix' => 'admin'],function(){
    Route::apiResource('product', AdminProductController::class);
});

/**
 * 使用者
 */
Route::group(['prefix' => 'client'],function(){
    Route::get('product', [ClientProductController::class, 'index']);
    Route::get('product/{id}', [ClientProductController::class, 'show']);

    Route::post('cart/product/{id}', [CartController::class, 'addProduct']);
    Route::put('cart/product/{id}', [CartController::class, 'updateProduct']);
    Route::delete('cart/product/{id}', [CartController::class, 'removeProduct']);

    Route::post('cart/address', [CartController::class, 'address']);
    Route::post('cart/delivery', [CartController::class, 'delivery']);
    Route::post('cart/payment', [CartController::class, 'paymnet']);
    Route::post('cart/checkout', [CartController::class, 'checkout']);
});
