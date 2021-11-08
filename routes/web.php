<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsizeController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
///////Products section
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', [ProductController::class, 'all'])->name('all.products');
        Route::get('add', [ProductController::class, 'add_view'])->name('add.products.view');
        Route::post('store', [ProductController::class, 'add'])->name('add.products');
        Route::get('delete', [ProductController::class, 'delete_view'])->name('delete.products.view');
        Route::get('edit', [ProductController::class, 'edit_view'])->name('edit.products.view');
        Route::post('save_edit', [ProductController::class, 'edit'])->name('edit.products');
    });

    Route::group(['prefix' => 'product-size'], function () {
        Route::post('store-m', [ProductsizeController::class, 'add_m'])->name('add.product.size.m');
        Route::post('store-l', [ProductsizeController::class, 'add_l'])->name('add.product.size.l');
    });

///////Selling section
    Route::group(['prefix' => 'sell'], function () {
        Route::post('/', [HomeController::class, 'sell'])->name('sell.products');
        Route::get('/new', [HomeController::class, 'sell_new'])->name('sell.new.products');
        Route::get('/old/{order_id}', [HomeController::class, 'sell_old'])->name('sell.old.products');
        Route::post('/remove', [HomeController::class, 'remove'])->name('remove.products');
        Route::get('/delete/{order_id}', [HomeController::class, 'delete'])->name('delete.order');
    });

///////final order section
    Route::group(['prefix' => 'order'], function () {
        Route::post('/final', [OrderController::class, 'final_order'])->name('final.order');
        Route::get('/all', [OrderController::class, 'all_orders'])->name('all.orders');
        Route::get('/{order_number}', [OrderController::class, 'order'])->name('order');
    });

///////el mwz3een section
    Route::group(['prefix' => 'company'], function () {
        Route::get('/all', [CompanyController::class, 'all_companies'])->name('all.companies');
        Route::get('/add-view', function(){ return view('companies.add'); })->name('add.companies.view');
        Route::post('/add', [CompanyController::class, 'add_companies'])->name('add.companies');
        Route::get('edit', [CompanyController::class, 'edit_view'])->name('edit.companies.view');
        Route::post('/save-edit', [CompanyController::class, 'edit_companies'])->name('edit.companies');
    });

///////el expenses section
    Route::group(['prefix' => 'expenses'], function () {
        Route::post('/add-quantity', [ExpenseController::class, 'add_quantity'])->name('add.product.quantity');
    });

///////Admin section
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });
});
