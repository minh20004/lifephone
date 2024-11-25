<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\FavoriteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/search-suggestions', [ApiProductController::class, 'getSearchSuggestions']);
Route::get('/search-trend', [ApiProductController::class, 'getTopProductsForSearch']);

Route::post('favorites', [FavoriteController::class, 'addToFavorites']);
Route::post('favorites/delete', [FavoriteController::class, 'removeFromFavorites']);
Route::get('/favorites', [FavoriteController::class, 'getFavorites']);
Route::post('favorites/addToCard', [FavoriteController::class, 'addToCart']);
