<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
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

});
