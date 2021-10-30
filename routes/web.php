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
