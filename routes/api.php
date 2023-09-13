<?php


use App\Http\Controllers\Api\V1\Admin\BasketController;
use App\Http\Controllers\Api\V1\Admin\BlogController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\CommentController;
use App\Http\Controllers\Api\V1\Admin\CouponController;
use App\Http\Controllers\Api\V1\Admin\DiscountController;
use App\Http\Controllers\Api\V1\Admin\GalleryController;
use App\Http\Controllers\Api\V1\Admin\IpController;
use App\Http\Controllers\Api\V1\Admin\OrderController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
use App\Http\Controllers\Api\V1\Admin\ProductPropertyController;
use App\Http\Controllers\Api\V1\Admin\ProjectController;
use App\Http\Controllers\Api\V1\Admin\PropertyController;
use App\Http\Controllers\Api\V1\Admin\PropertyGroupController;
use App\Http\Controllers\Api\V1\Admin\RecruitmentController;
use App\Http\Controllers\Api\V1\Admin\ReportController;
use App\Http\Controllers\Api\V1\Admin\RoleController;
use App\Http\Controllers\Api\V1\Admin\SellerController;
use App\Http\Controllers\Api\V1\Admin\ServiceController;
use App\Http\Controllers\Api\V1\Admin\ServiceGroupController;
use App\Http\Controllers\Api\V1\Admin\SmsController;
use App\Http\Controllers\Api\V1\Admin\TicketController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\VisitController;
use App\Http\Controllers\Api\V1\Admin\WorkSampleController;
use Illuminate\Support\Facades\Route;


//use App\Http\Controllers\Api\V1\Admin\BlogController;


//use App\Http\Controllers\Api\V1\Admin\SellerController;
//use App\Http\Controllers\Api\V1\Admin\UserController;


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
//public routes

Route::group(['prefix' => 'v1' , 'namespace' => 'App\Http\Controllers\Api\V1\Admin'], function (){

    Route::apiResource('/visits', VisitController::class)->only('index', 'store');
    Route::get('/visits/counts', [VisitController::class, 'allVisits']);



    Route::get('products/search/{value}', [ProductController::class, 'search']);
    Route::get('blogs/search/{value}', [BlogController::class, 'search']);


    Route::post('users/register', [UserController::class, 'store']);

    Route::post('users/login', [UserController::class, 'login']);


    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{product}', [ProductController::class, 'show']);

    Route::get('baskets', [BasketController::class, 'show']);






    //product properties
    Route::get('products/{product}/properties',[ProductPropertyController::class,'index']);
    Route::post('products/{product}/properties',[ProductPropertyController::class,'store']);


    //Gallery Routes
    Route::get('/galleries/{product}' , [GalleryController::class,'index']);





    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::delete('orders', [OrderController::class, 'destroy']);


    Route::apiResource('tickets', TicketController::class);
    Route::post('users/doChangePassword', [UserController::class,'doChangePassword']);







});


//private routes

Route::group(['prefix' => 'v1' , 'namespace' => 'App\Http\Controllers\Api\V1\Admin',
    'middleware' => 'auth:sanctum'], function (){

    Route::apiResource('categories' , CategoryController::class)->except('index', 'show');
    Route::apiResource('products' , ProductController::class)->except('index', 'show');
    Route::apiResource('products.discounts', DiscountController::class);
    Route::apiResource('propertiesGroup',PropertyGroupController::class);
    Route::apiResource('properties',PropertyController::class);
    Route::apiResource('serviceGroups' , ServiceGroupController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('ips', IpController::class);
    Route::apiResource('roles' , RoleController::class);
    Route::apiResource('baskets', BasketController::class)->except('update', 'show');
    Route::apiResource('users', UserController::class)->except('store');

    Route::get('users/detail', [UserController::class, 'show']);
    Route::post('users/logout', [UserController::class, 'logout']);

    Route::post('/galleries/{product}' , [GalleryController::class,'store']);
    Route::delete('/galleries/{gallery}' , [GalleryController::class,'destroy']);

    Route::apiResource('blogs', BlogController::class);

    Route::apiResource('sellers', SellerController::class);
    Route::put('orders/confirm/{id}', [OrderController::class, 'confirmOrder']);

    Route::apiResource('reports', ReportController::class)->only(['index', 'store', 'update']);

    Route::apiResource('projects', ProjectController::class)->only(['index']);

    Route::apiResource('work-sample', WorkSampleController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::apiResource('recruitments', RecruitmentController::class)->only(['index', 'show']);

    Route::get('comments', [CommentController::class, 'index'])->name('comment.index');
    Route::get('comments/{comment}', [CommentController::class, 'show']);
    Route::put('comments/confirm/{id}', [CommentController::class, 'confirmComment'])->name('comment.confirm');
    Route::delete('comments/{id}', [Commentcontroller::class, 'destroy'])->name('comment.destroy');

    Route::get('coupons', [CouponController::class, 'index']);
    Route::get('coupons/{coupon}', [CouponController::class, 'show']);
    Route::post('coupons', [CouponController::class, 'store']);
    Route::put('coupons/{id}', [CouponController::class, 'update']);
    Route::delete('coupons/{id}', [CouponController::class, 'destroy']);

    Route::post('/users/changePassword',[UserController::class,'changePassword']);

    Route::post('sms/sendVerify',[SmsController::class,'sendSms']);
    Route::post('sms/verify',[SmsController::class,'verify']);
});
