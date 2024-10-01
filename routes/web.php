<?php

use App\Http\Controllers\AuthController;
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
<<<<<<< HEAD
})->name('user.home');

// admin
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.home');// ->middleware('isAdmin')->name('admin.home');

Route::get('/them-thanh-vien', [AuthController::class, 'create'])->name('admin.them-thanh-vien');
Route::get('/thanh-vienit ', [AuthController::class, 'index'])->name('admin.thanh-vien');
Route::resource('users', AuthController::class);
=======
});

// duy taan 
>>>>>>> b2efbbfaaf22f41b3b5faf7f6af28023396ba5e0
