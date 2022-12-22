<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\CommentController;
use App\Http\Controllers\Api\V1\Admin\CouponController;
use App\Http\Controllers\Api\V1\Admin\DiscountController;
use App\Http\Controllers\Api\V1\Admin\GalleryController;
use App\Http\Controllers\Api\V1\Admin\OrderController;
use App\Http\Controllers\Api\V1\Admin\ProductController;

use App\Http\Controllers\Api\V1\Admin\UserController;

use App\Http\Controllers\Api\V1\Admin\BlogController;


use App\Http\Controllers\Api\V1\Admin\ProductPropertyController;
use App\Http\Controllers\Api\V1\Admin\PropertyController;
use App\Http\Controllers\Api\V1\Admin\PropertyGroupController;


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

// api/v1

Route::group(['prefix' => 'v1' , 'namespace' => 'App\Http\Controllers\Api\V1\Admin'], function (){
    Route::apiResource('categories' , CategoryController::class);
    Route::apiResource('products' , ProductController::class);
    Route::apiResource('products.discounts', DiscountController::class);
    Route::apiResource('propertiesGroup',PropertyGroupController::class);
    Route::apiResource('properties',PropertyController::class);

    //product properties
    Route::get('products/{product}/properties',[ProductPropertyController::class,'index']);
    Route::post('products/{product}/properties',[ProductPropertyController::class,'store']);


    //Gallery Routes
    Route::get('/galleries/{product}' , [GalleryController::class,'index']);
    Route::post('/galleries/{product}' , [GalleryController::class,'store']);
    Route::delete('/galleries/{gallery}' , [GalleryController::class,'destroy']);

    /* Comment Routes */
    Route::get('comments', [CommentController::class, 'index'])->name('comment.index');
    Route::get('comments/{comment}', [CommentController::class, 'show']);
    Route::put('comments/confirm/{id}', [CommentController::class, 'confirmComment'])->name('comment.confirm');
    Route::delete('comments/{id}', [Commentcontroller::class, 'destroy'])->name('comment.destroy');
    /* Comment Routes */

    /* Coupon Routes */
    Route::get('coupons', [CouponController::class, 'index']);
    Route::get('coupons/{coupon}', [CouponController::class, 'show']);
    Route::post('coupons', [CouponController::class, 'store']);
    Route::put('coupons/{id}', [CouponController::class, 'update']);
    Route::delete('coupons/{id}', [CouponController::class, 'destroy']);
    /* Coupon Routes */

    /* Order Routes */
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::delete('orders', [OrderController::class, 'destroy']);
    Route::put('orders/confirm/{id}', [OrderController::class, 'confirmOrder']);
    /* Order Routes */

    /* User Routes */
    Route::apiResource('users', UserController::class)->only('index', 'destroy');
    /* User Routes */

    /* Blog Routes */
    Route::apiResource('blogs', BlogController::class);
    /* Blog Routes */

});
