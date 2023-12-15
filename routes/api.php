<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ExportController;
use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\APi\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\BannerAndSlideController;
use App\Http\Controllers\API\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product'

], function () {

    Route::get('category/{parent_id}', [CategoryController::class, 'category'])->name('category');
    Route::get('allproduct', [ProductController::class, 'allProduct'])->name('all_product');
    Route::get('product/{category_id}', [ProductController::class, 'product'])->name('product');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'order'

], function () {

    Route::post('order',[OrderController::class, 'order'])->name('order');
    Route::post('order_items', [OrderController::class, 'order_items'])->name('order_items');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'banner_and_slide'
], function () {
    Route::get('banner_and_slide', [BannerAndSlideController::class, 'banner_and_slide'])->name('banner_and_slide');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'review'
], function () {
    Route::post('get_comment', [ReviewController::class, 'get_comment'])->name('get_comment');
    Route::post('get_star', [ReviewController::class, 'get_star'])->name('get_star');

    Route::get('return_review', [ReviewController::class, 'return_review'])->name('return_review');
});



