<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutSeviceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route("admin.user.index");
});
Route::get('uploads/')->name("urlPathUploads");

Route::get('auth/login', [LoginController::class, 'viewLogin'])->name('viewLogin');
Route::post('auth/login', [LoginController::class, 'login'])->name('login');
Route::get('auth/logout', LogoutSeviceController::class)->name('logout');




Route::prefix('admin')->name('admin.')
->group(function () {

    Route::prefix('user')->name('user.')->controller(UserController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //find and get data
        Route::post('get-users', 'getUsers')->name('getUsers');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });


    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //find and get data
        Route::post('get-products', 'getProducts')->name('getProducts');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('transaction')->name('transaction.')->controller(TransactionController::class)->group(function () {
        //view
        Route::get('import', 'import')->name('import');
        Route::get('export', 'export')->name('export');
        Route::get('supplier', 'supplier')->name('supplier');

        //find and get data
        Route::post('get-imports', 'getImports')->name('getImports');
        Route::post('find-import', 'findImport')->name('findImport');
        Route::post('get-export', 'getExports')->name('getExports');

        //create 
        Route::post('store-import', 'importStore')->name('importStore');
        Route::post('store-export', 'exportStore')->name('exportStore');
        Route::post('store-supplier', 'supplierStore')->name('supplierStore');

        // edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });


});
