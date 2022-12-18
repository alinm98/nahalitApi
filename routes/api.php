<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\GalleryController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\CommentController;
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

// api/v1

Route::group(['prefix' => 'v1' , 'namespace' => 'App\Http\Controllers\Api\V1\Admin'], function (){
    Route::apiResource('categories' , CategoryController::class);
    Route::apiResource('products' , ProductController::class);
//    Route::apiResource('galleries' , GalleryController::class);
    Route::get('/galleries/{product}' , [GalleryController::class,'index']);
    Route::post('/galleries/{product}' , [GalleryController::class,'store']);
    Route::delete('/galleries/{gallery}' , [GalleryController::class,'destroy']);

    /* Comment Routes */
    Route::get('comment', [CommentController::class, 'index'])->name('comment.index');
    Route::put('comment/confirm/{id}', [CommentController::class, 'confirmComment'])->name('comment.confirm');
    Route::delete('comment/{id}', [Commentcontroller::class, 'destroy'])->name('comment.destroy');
    /* Comment Routes */

});
