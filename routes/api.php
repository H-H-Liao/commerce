<?php
use App\Http\Controllers\Admin\ProductController as AdminProductController;
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
    Route::apiResource('product', ClientProductController::class);
});
