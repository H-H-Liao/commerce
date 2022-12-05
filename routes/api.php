<?php
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DeliveryController as AdminDeliveryController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Client\AddressControlelr;
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
    Route::apiResource('delivery', AdminDeliveryController::class);
    Route::apiResource('payment', AdminPaymentController::class);
});

/**
 * 使用者
 */
Route::group(['prefix' => 'client', 'middleware' => ['auth:api']],function(){
    Route::get('product', [ClientProductController::class, 'index']);
    Route::get('product/{id}', [ClientProductController::class, 'show']);

    Route::get('cart', [CartController::class, 'index']);
    Route::post('cart/product/{id}', [CartController::class, 'addProduct']);
    Route::put('cart/product/{id}', [CartController::class, 'updateProduct']);
    Route::delete('cart/product/{id}', [CartController::class, 'removeProduct']);
    Route::post('cart/checkout', [CartController::class, 'checkout']);

    Route::apiResource('address', AddressControlelr::class);
});
