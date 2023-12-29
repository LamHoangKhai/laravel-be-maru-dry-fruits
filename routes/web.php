<?php


use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Craw;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\CrawController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\WeightTagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutSeviceController;
use App\Models\Order;
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

Route::get('uploads/')->name("uploads");
Route::get('qrcode/')->name('qrcode');
Route::get('auth/login', [LoginController::class, 'viewLogin'])->name('viewLogin');
Route::post('auth/login', [LoginController::class, 'login'])->name('login');
Route::get('auth/logout', LogoutSeviceController::class)->name('logout');

Route::get('team/hello-world/craw-data', [CrawController::class, "run"])->name('craw');



Route::prefix('admin')->name('admin.')->middleware(['auth:web', "checkLogin"])->group(function () {

    Route::prefix('category')->name('category.')->controller(CategoryController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');

        //api
        Route::post('check-related', 'checkRelatedCategory')->name('checkRelatedCategory');
    });

    Route::prefix('product')->name('product.')->controller(ProductController::class)->group(function () {
        //view 
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');



        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');


        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');

        //api
        Route::post('detail', 'detail')->name('detail');
        Route::post('get-products', 'getProducts')->name('getProducts');
        Route::post('remove-weight-tag', 'removeWeightTag')->name('removeWeightTag');
        Route::post('check-quantity', 'checkQuantity')->name('checkQuantity');





        Route::prefix('warehouse')->name('warehouse.')->controller(WarehouseController::class)->group(function () {
            //view
            Route::get('log/{id}', 'log')->name('log');

            Route::get('create-import/{id}', 'createImport')->name('createImport');
            Route::get('create-export/{id}', 'createExport')->name('createExport');

            //create 
            Route::post('store-import', 'importStore')->name('importStore');
            Route::post('store-export', 'exportStore')->name('exportStore');

            // edit and update import
            Route::get('edit-import/{id}', 'editImport')->name('editImport');
            Route::post('update-import/{id}', 'updateImport')->name('updateImport');

            //api 
            Route::post('get-log', 'getLog')->name('getLog');

        });

    });


    Route::prefix('user')->middleware('checkLogin')->name('user.')->controller(UserController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');

        //api
        Route::post('get-users', 'getUsers')->name('getUsers');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('order')->name('order.')->controller(OrderController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('history', 'history')->name('history');
        Route::get('create', 'create')->name('create');
        Route::post('checking', 'checking')->name('checking');

        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');

        //api
        Route::post('get-list-order', 'getListOrder')->name('getListOrder');
        Route::post('get-history-order', 'getHistoryOrder')->name('getHistoryOrder');
        Route::post('get-order-detail', 'getOrderDetail')->name('getOrderDetail');
        Route::post('update-status', 'updateStatus')->name('updateStatus');
        Route::post('cancel-order', 'cancelOrder')->name('cancelOrder');
        Route::post('add-discount', 'addDiscount')->name('addDiscount');
    });



    Route::prefix('supplier')->name('supplier.')->controller(SupplierController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');


        //create 
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });

    Route::prefix('weight-tag')->name('weight-tag.')->controller(WeightTagController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');

        //create 
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');
    });


    Route::fallback(function () {
        abort(404);
    });

    Route::prefix('slider-banner')->name('slider-banner.')->controller(BannerSliderController::class)->group(function () {
        //view
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        //create
        Route::post('store', 'store')->name('store');

        //edit and update
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');

        //destroy
        Route::get('destroy/{id}', 'destroy')->name('destroy');


    });

});

Route::fallback(function () {
    abort(404);
});
