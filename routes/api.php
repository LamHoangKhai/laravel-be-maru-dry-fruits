<?php

use App\Events\UserOrder;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ExportController;
use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\BannerAndSlideController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\MailController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReviewController;
use App\Models\Order;
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
    Route::post('edit_profile', [AuthController::class, 'edit_profile'])->name('edit_profile');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'product'

], function () {

    Route::get('category', [CategoryController::class, 'category'])->name('category');

    Route::post('allproduct', [ProductController::class, 'allproduct'])->name('allproduct');
    Route::post('product_details', [ProductController::class, 'product_details'])->name('product_details');
    Route::post('search_product', [ProductController::class, 'search_product'])->name('search_product');

    Route::get('highest_rating_products', [ProductController::class, 'highest_rating_products'])->name('highest_rating_products');
    Route::get('featured_products', [ProductController::class, 'featured_products'])->name('featured_products');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'order'

], function () {

    Route::post('order', [OrderController::class, 'order'])->name('order');
    Route::get('history_order', [OrderController::class, 'history_order'])->name('history_order');
    Route::post('history_order_details', [OrderController::class, 'history_order_details'])->name('history_order_details');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'banner_and_slide'
], function () {
    Route::post('banner_and_slide', [BannerAndSlideController::class, 'banner_and_slide'])->name('banner_and_slide');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'review'
], function () {
    Route::post('get_comment', [ReviewController::class, 'get_comment'])->name('get_comment');
    Route::post('get_star', [ReviewController::class, 'get_star'])->name('get_star');

    Route::get('return_review', [ReviewController::class, 'return_review'])->name('return_review');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'feedback'
], function () {
    Route::post('feedback', [FeedbackController::class, 'feedback'])->name('feedback');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'vnpay'
], function () {
    Route::post('vnpay_payment', [PaymentController::class, 'vnpay_payment'])->name('vnpay_payment');
});
