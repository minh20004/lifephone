<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FrontendControlle;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientNewController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryNewsController;

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserNotificationController;
use App\Http\Controllers\OrderNotificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;

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
// Route::get('/', function () {
//     return view('index');
// })->name('user.home');
Route::get('/danhm-muc/{id}/products', [FrontendControlle::class, 'getProductsByCategory'])->name('client.danhmuc.products');

// font end trang chủ
Route::get('/', [FrontendControlle::class, 'index'])->name('home');
// Route cho người dùng bình thường - chỉ cần xác thực người dùng
Route::middleware('auth:customer')->group(function () {
    Route::resource('product', ProductController::class)->only([
        'index', 'show'
    ]);
});





// auth admin ------------------------------------------------------------------------------------------------------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');




Route::get('admin/verify/{token}', [AuthController::class, 'verify'])->name('verification.verify');

// Route gửi lại email xác minh
Route::post('admin/resend-verification', [AuthController::class, 'resendVerification'])->name('admin.resendVerification');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', 'Tài khoản của bạn đã được xác minh.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Email xác minh đã được gửi.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');




Route::resource('product', ProductController::class);

Route::middleware(['auth:admin', 'isAdmin'])->group(function () {
    Route::resource('product-admin', ProductController::class);

    Route::get('/admin', [AuthController::class, 'Dashboards'])->name('admin.home');

    Route::get('/them-thanh-vien', [AuthController::class, 'create'])->name('admin.them-thanh-vien');
    Route::get('/thanh-vien', [AuthController::class, 'index'])->name('admin.thanh-vien');
    Route::get('cap-nhat/thanh-vien/{id}/edit', [AuthController::class, 'edit'])->name('admin.edit');
    Route::get('profile/admin', [AuthController::class, 'hoso'])->name('admin.profile');
    
    Route::resource('admins', AuthController::class);

    Route::resource('new_admin',  NewController::class);
    Route::resource('category_news', CategoryNewsController::class);
    Route::resource('index', AdminController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('capacity', CapacityController::class);
    Route::resource('color', ColorController::class);
    Route::prefix('products')->group(function () {
        Route::get('/trashed', [ProductController::class, 'trashed'])->name('product.trashed');
        Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('product.restore');
        Route::get('trashed/{id}/variants', [ProductController::class, 'showVariants'])->name('product.variants');
    
    });
    // order
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('order.show');

    // Route cho admin xác nhận yêu cầu hủy đơn hàng
    Route::get('/admin/orders/cancel-requests', [OrderController::class, 'cancelRequests'])->name('order.cancelRequests');
    Route::post('/admin/order/confirm-cancel/{id}', [OrderController::class, 'confirmCancel'])->name('order.confirmCancel');

    // Route cho Voucher
    // Route::resource('vouchers', VoucherController::class);
    Route::resource('vouchers', VoucherController::class);

    // sub;
    Route::resource('/subscriptions', SubscriptionController::class)->except(['show']);
    // Trang gửi email hàng loạt
    Route::get('/subscriptions/send', [SubscriptionController::class, 'create'])->name('subscriptions.create'); // Form gửi email
    // Trang hiển thị các email đã gửi (giả sử bạn có một bảng ghi lại thông tin các email đã gửi)
    Route::get('/subscriptions/index', [SubscriptionController::class, 'sentEmails'])->name('subscriptions.index');
    // routes/web.php
    Route::post('/subscriptions/send', [SubscriptionController::class, 'sendBulkEmails'])->name('subscriptions.send');

    Route::get('/get-statistics', [DashboardController::class, 'getStatistics'])->name('admin.getStatistics');


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
    // Route::resource('new_admin',  NewController::class);

    // thông báo khi đặt hàng thành công 
    Route::get('/admin/notifications', [OrderNotificationController::class, 'index'])->name('admin.notifications');
    Route::post('/admin/notifications/{id}/read', [OrderNotificationController::class, 'markAsRead'])->name('admin.notifications.read');

});
// end auth admin ------------------------------------------------------------------------------------------------------------------














// auth customer ------------------------------------------------------------------------------------------------------------------------------
// quản lý hồ sơ khách hàng
Route::get('/customer/address', [AuthController::class, 'address'])->name('customer.adress');

Route::get('/customer/add', [AuthController::class, 'createCustomer'])->name('customer.add');
Route::post('/customer/creat', [AuthController::class, 'storeCustomer'])->name('customer.creat');
Route::put('/customer/{id}/update', [AuthController::class, 'updateCustomer'])->name('customer.update');
Route::put('/customer/{id}/updateContact', [AuthController::class, 'updateContact'])->name('customer.updateContact');
// Route::put('/customer/{id}/changePassword', [AuthController::class, 'changePassword'])->name('customer.changePassword');

Route::put('/customer/update-avatar/{id}', [AuthController::class, 'updateAvatar'])->name('customer.updateAvatar');
Route::delete('/customer/{id}/avatar', [AuthController::class, 'deleteAvatar'])->name('customer.deleteAvatar');

Route::get('/verify/{token}', [AuthController::class, 'verifyCustomer'])->name('customer.verify');
// Route để gửi lại email xác nhận
Route::post('/customer/resend-verification', [AuthController::class, 'resendVerificationEmail'])->name('customer.resend.verification');

Route::get('/customer/login', [AuthController::class, 'showLogin_customer'])->name('customer.login');
Route::post('/customer/login', [AuthController::class, 'customerLogin'])->name('customer.login.submit');
Route::post('/customer/logout', [AuthController::class, 'customerLogout'])->name('customer.logout');

Route::middleware(['auth:customer', 'isCustomer'])->group(function () {
    Route::put('/customer/{id}/changePassword', [AuthController::class, 'changePassword'])->name('customer.changePassword');

    Route::post('/update-email', [AuthController::class, 'updateEmail'])->name('customer.updateEmail');
    
    Route::get('/customer/verify-email-change/{token}', [AuthController::class, 'verifyEmailChange'])->name('customer.verifyEmailChange');
    // Route::get('/verify-new-email/{token}', [AuthController::class, 'verifyNewEmail'])->name('customer.verifyNewEmail');

    Route::get('/customer/address', [AuthController::class, 'address'])->name('customer.adress');
    Route::get('/customer/file', [AuthController::class, 'file_customer'])->name('customer.file');
    Route::put('/customer/{id}/update-address', [AuthController::class, 'updateAddress'])->name('customer.updateAddress');
    Route::get('/customer/file', [AuthController::class, 'file_customer'])->name('customer.file');
    Route::get('/customer/wishList', [AuthController::class, 'wish_list'])->name('customer.wishList');

    Route::get('/order-history', [AuthController::class, 'history'])->name('order.history');
    // Route thêm địa chỉ
    Route::post('/customer/address', [AddressController::class, 'addAddress'])->name('customer.addAddress');
    // Route xóa địa chỉ
    Route::delete('/customer/address/{addressId}', [AddressController::class, 'deleteAddress'])->name('customer.deleteAddress');
    // Route đặt địa chỉ làm mặc định
    Route::get('/customer/address/{addressId}/set-default', [AddressController::class, 'setDefaultAddress'])->name('customer.setDefaultAddress');
    // Route cập nhật địa chỉ
    Route::put('/customer/address/{addressId}', [AddressController::class, 'updateAddress'])->name('customer.updateAddress');
    Route::get('/order-detail/{id}', [AuthController::class, 'detail'])->name('order.detail');

    Route::get('/cart/items', [CartController::class, 'getCartItems']);
    Route::post('/cart/select-items', [CartController::class, 'selectCartItemsForCheckout']);
});

// Route::get('/order-detail/{id}', [AuthController::class, 'detail'])->name('order.detail');
// end auth customer ------------------------------------------------------------------------------------------------------





// -----------------------------USER------------------------------------------------------------------------------
//giỏ hàng
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
// Route::post('cart/remove/{productId}/{modelId}/{colorId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
// Route::post('/cart/apply-voucher', [CartController::class, 'applyVoucher'])->name('cart.apply-voucher');
// Route::get('/cart/offcanvas', [CartController::class, 'getCart'])->name('cart.offcanvas');

// thanh toán

// Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

// Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Route::post('/checkout/selected', [CartController::class, 'checkoutSelected'])->name('checkout.selected');
// Route::post('/cart/prepare-checkout', [CartController::class, 'prepareCheckout'])->name('cart.prepareCheckout');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/order/store', [OrderController::class, 'storeOrder'])->name('order.store');
Route::get('/order-success', function () {
    return view('client.page.checkout.order_success'); // Thông báo thành công
})->name('order.success');

// Route::post('/payment/vnpay', [OrderController::class, 'payWithVNPay'])->name('payment.vnpay');
// Route::get('/payment/vnpay/callback', [OrderController::class, 'handleVNPayCallback'])->name('order.vnpay.callback');



Route::post('/apply-voucher', [OrderController::class, 'applyVoucher'])->name('order.applyVoucher');

// Route cho khách hàng yêu cầu hủy đơn hàng
Route::post('/order/cancel/{id}', [AuthController::class, 'cancel'])->name('order.cancel');

// thông báo khi đặt hàng thành công 
// Route::get('/admin/notifications', [OrderNotificationController::class, 'index'])->name('admin.notifications');
Route::post('/admin/notifications/{id}/read', [OrderNotificationController::class, 'markAsRead'])->name('admin.notifications.read');


Route::get('/public-order-history', [AuthController::class, 'publicHistory'])->name('order.publicHistory');
Route::get('/public-order-detail/{id}', [AuthController::class, 'publicDetail'])->name('order.publicDetail');

Route::post('/cart/item-count', [CartController::class, 'getCartItemCount'])->name('cart.item-count'); //cập nhật số lượng trong giỏ hàng 

// thanh toán vnpay
Route::post('/vnpay-payment', [OrderController::class,'vnpay_payment'])->name('vnpay.payment');

Route::post('/order', [OrderController::class, 'storeOrder'])->name('order.store');

// Route để bắt đầu thanh toán VNPay
Route::post('/order/vnpay', [OrderController::class, 'vnpay_payment'])->name('order.vnpay');

// Route để xử lý callback từ VNPay
Route::get('/order/vnpay/callback', [OrderController::class, 'vnpay_callback'])->name('order.vnpay_callback');

Route::get('/order-failure', function () {
    return view('client.page.checkout.order_failure'); // Thông báo thất bại
})->name('order.failure');
// thanh toán lại
Route::post('/order/{id}/retry-payment', [OrderController::class, 'retryPayment'])->name('order.retryPayment');
// web.php
Route::get('/checkout-failure/{id}', [OrderController::class, 'retryPayment'])->name('checkout-failure');
// Trong web.php
Route::get('/checkout/{order_id}', [OrderController::class, 'retryPayment'])->name('checkout-vnpay');



// ------------------------------------------------- ADMIN---------------------------------------------------------
// //router review và news
// Route::resource('admin/review',ReviewController::class);
// Route::resource('new_admin',  NewController::class);

Route::get('new', [NewController::class, 'clientIndex'])->name('news.index');

//Shop
Route::get('/shop', [ClientCategoryController::class, 'shop'])->name('shop');
Route::get('/categories/{id}/products', [ClientCategoryController::class, 'getProductsByCategory'])->name('client.category.products');
// Route::get('/filter-products', [ClientCategoryController::class, 'filterProducts']);
// Route::get('/products/filter', [ClientCategoryController::class, 'filterProducts'])->name('products.filter');


// Route::get('/category/{id}/products/filter', [ClientCategoryController::class, 'filterProducts'])->name('category.filterProducts');


// chat
Route::get('/chat', [chatController::class, 'index'])->name('chat');

Route::post('/chat/start', [ChatController::class, 'startConversation'])->name('chat.start');
Route::post('/chat/{conversationId}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/{conversationId}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

Route::get('/new/{slug}', [NewController::class, 'singlepost'])->name('news.show');
Route::get('/new/category/{slug}', [NewController::class, 'categoryNewsBlog'])->name('categoryNewsBlog');

Route::get('/search', [ClientCategoryController::class, 'search'])->name('product.search');
// categoy product
Route::get('/danh-muc-san-pham', [FrontendControlle::class, 'index_cate_all'])->name('danh-muc-san-pham');
