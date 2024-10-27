<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FrontendControlle;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ClientNewController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NewController;

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

// Route::get('/', function ():View {
//     return view('admin.index');
// });

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
Route::resource('index', AdminController::class);
Route::resource('category', CategoryController::class);
Route::resource('capacity', CapacityController::class);
Route::resource('color', ColorController::class);

//  route cho phần sản phẩm bị xóa 
Route::prefix('products')->group(function () {
    Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    
});

// Route danh mục bị xóa 
Route::prefix('categories')->group(function () {
    Route::get('/trashed', [CategoryController::class, 'trashed'])->name('category.trashed');
    Route::post('/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::get('trashed/{id}/variants', [ProductController::class, 'showVariants'])->name('product.variants');

});
// Route dung lượng bị xóa 
Route::prefix('capacities')->group(function () {
    Route::get('/trashed', [CapacityController::class, 'trashed'])->name('capacity.trashed');
    Route::post('/restore/{id}', [CapacityController::class, 'restore'])->name('capacity.restore');
});
// Route màu sắc bị xóa 
Route::prefix('colors')->group(function () {
    Route::get('/trashed', [ColorController::class, 'trashed'])->name('color.trashed');
    Route::post('/restore/{id}', [ColorController::class, 'restore'])->name('color.restore');
});
// chuyển trang biến thể 
Route::get('/product/{id}/variants', [ProductController::class, 'showVariants'])->name('product.variants');
//router review và news
Route::resource('admin/review',ReviewController::class);
Route::resource('new_admin',  NewController::class);

Route::get('new', [NewController::class, 'clientIndex'])->name('news.index');
