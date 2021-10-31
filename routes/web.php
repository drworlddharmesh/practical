<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
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


//shop
Route::prefix('shop')->group(function () {
    Route::get('shop', [ShopController::class, 'ShopList']);
    Route::get('shopDataTable', [ShopController::class, 'ShopListDataTable'])->name('ShopDataTable');
    Route::get('add-shop', [ShopController::class, 'AddShop']);
    Route::post('insert-shop', [ShopController::class, 'InsertShop']);
    Route::post('delete-shop', [ShopController::class, 'DeleteShop']);
    Route::get('edit-shop/{id}', [ShopController::class, 'EditShop']);
    Route::post('update-shop', [ShopController::class, 'UpdateShop']);
});
Route::prefix('product')->group(function () {
    Route::get('product/{id}', [ProductController::class, 'ProductList']);
    Route::get('productDataTable/{id}', [ProductController::class, 'ProductListDataTable']);
    Route::get('add-product/{id}', [ProductController::class, 'AddProduct']);
    Route::post('add-product/check-product_name', [ProductController::class, 'CheckProduct']);
    Route::post('insert-product', [ProductController::class, 'InsertProduct']);
    Route::post('delete-product', [ProductController::class, 'DeleteProduct']);
    Route::get('edit-product/{id}/{ProductId}', [ProductController::class, 'EditProduct']);
    Route::post('update-product', [ProductController::class, 'UpdateProduct']);
    Route::post('edit-product/{id}/check-product_name', [ProductController::class, 'UpdateCheckProduct']);

    Route::get('bulk-product/{id}', [ProductController::class, 'BulkProduct']);
    Route::post('bulk-insert-product', [ProductController::class, 'InsertBulkProduct']);
});
