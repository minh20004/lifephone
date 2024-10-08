<?php

<<<<<<< HEAD
use App\Http\Controllers\VoucherController;
=======
use App\Http\Controllers\AuthController;
>>>>>>> 9176f12 (crud auth)
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
<<<<<<< HEAD
    return view('admin.index');
});

Route::resource('vouchers', VoucherController::class);
=======
    return view('index');
})->name('user.home');

// admin
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.home');// ->middleware('isAdmin')->name('admin.home');

Route::get('/them-thanh-vien', [AuthController::class, 'create'])->name('admin.them-thanh-vien');
Route::get('/thanh-vien', [AuthController::class, 'index'])->name('admin.thanh-vien');
Route::resource('users', AuthController::class);
>>>>>>> 9176f12 (crud auth)
