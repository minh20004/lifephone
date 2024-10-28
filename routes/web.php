<?php

use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\VoucherController;
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
    return view('index');
});

Route::resource('vouchers', VoucherController::class);

Route::get('/shop', [ClientCategoryController::class, 'shop'])->name('shop');
Route::get('/products/filter', [ClientCategoryController::class, 'filter'])->name('products.filter');
// Route::get('/index', [ClientCategoryController::class, 'index'])->name('index');
// Route::get('/shop-catalog', [ClientCategoryController::class, 'latestProducts'])->name('shop-catalog');
// Route::get('/categories/{id}/products', [ClientCategoryController::class, 'getProductsByCategory']);
// Route::get('/products/filter-category', [ClientCategoryController::class, 'filterByCategory'])->name('products.filter.category'); 




