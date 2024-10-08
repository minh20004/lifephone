<?php

use App\Http\Controllers\NewController;
use App\Http\Controllers\ReviewController;
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

// Route::get('/', function ():View {
//     return view('admin.index');
// });
Route::resource('review',ReviewController::class);
Route::resource('new',NewController::class);
Route::get('/', function () {
    return view('admin.index');
});