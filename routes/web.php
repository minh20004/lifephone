<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryNewsController;
use App\Http\Controllers\chatController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FrontendControlle;
use App\Http\Controllers\NewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

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

// font end trang chủ
Route::get('/', [FrontendControlle::class, 'index'])->name('home');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
});

// -----------------------------USER------------------------------------------------------------------------------
//giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/remove/{productId}/{modelId}/{colorId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.apply-voucher');
Route::get('/cart/offcanvas', [CartController::class, 'getCart'])->name('cart.offcanvas');
// thanh toán
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/order/store', [OrderController::class, 'storeOrder'])->name('order.store');
Route::get('/order-success', function () {
    return view('client.page.checkout.order_success'); // Thông báo thành công
})->name('order.success');



// ------------------------------------------------- ADMIN---------------------------------------------------------
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

// order
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('order.show');

//  route cho phần sản phẩm bị xóa 
Route::prefix('products')->group(function () {
    Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
    Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
    Route::get('trashed/{id}/variants', [ProductController::class, 'showVariants'])->name('product.variants');
    
});


// Route danh mục bị xóa 
Route::prefix('categories')->group(function () {
    Route::get('/trashed', [CategoryController::class, 'trashed'])->name('category.trashed');
    Route::post('/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
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

Route::resource('category_news', CategoryNewsController::class);

Route::resource('vouchers', VoucherController::class);

Route::get('/shop', [ClientCategoryController::class, 'shop'])->name('shop');

Route::get('/categories/{id}/products', [ClientCategoryController::class, 'getProductsByCategory']);

Route::get('/new/{slug}', [NewController::class, 'singlepost'])->name('news.show');
Route::get('/new/category/{slug}', [NewController::class, 'categoryNewsBlog'])->name('categoryNewsBlog');
