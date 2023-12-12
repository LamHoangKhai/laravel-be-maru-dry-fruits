<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ExportController;
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

    Route::post('export', [ExportController::class, 'export'])->name('export');
});

// Route::prefix('admin')->name('api.')->group(function(){
//     Route::prefix('product')->name('product.')->group(function() {
//     });
// });
