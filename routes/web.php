<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\Admin\OrderController as AdminOrderController;

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

// Route::get('/', function () {
//     return view('index');
// });


Route::get('/', function () {
    return view('admin.index');
});



// Route Admin
Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status');
