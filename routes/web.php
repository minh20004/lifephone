<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoucherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Đây là nơi bạn đăng ký các route web cho ứng dụng của mình.
| Các route này sẽ được tải bởi RouteServiceProvider và
| thuộc nhóm "web" middleware.
|
*/

Route::get('/', function () {
    return view('index');
})->name('user.home');

// Các route dành cho Admin
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.home'); // ->middleware('isAdmin')->name('admin.home');

// Quản lý thành viên admin
Route::get('/them-thanh-vien', [AuthController::class, 'create'])->name('admin.them-thanh-vien');
Route::get('/thanh-vien', [AuthController::class, 'index'])->name('admin.thanh-vien');
Route::get('cap-nhat/thanh-vien/{id}/edit', [AuthController::class, 'edit'])->name('admin.edit');
Route::get('ho-so/admin', [AuthController::class, 'hoso'])->name('admin.hoso');
Route::resource('admins', AuthController::class);

// Route cho Voucher
Route::resource('vouchers', VoucherController::class);

// Route cho sản phẩm
Route::resource('product', ProductController::class);
Route::prefix('products')->group(function () {
    Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
});

<<<<<<< HEAD
Route::resource('index', AdminController::class);
Route::resource('product', ProductController::class);
Route::resource('category', CategoryController::class);

Route::prefix('products')->group(function () {
    Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
});

Route::prefix('products')->group(function () {
    Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
});
=======
// Route cho danh mục
Route::resource('category', CategoryController::class);
>>>>>>> 3c3012604c44fb4bc640b192d7f3ee4fb1cdacc6
Route::prefix('categories')->group(function () {
    Route::get('/trashed', [CategoryController::class, 'trashed'])->name('category.trashed');
    Route::post('/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
});
