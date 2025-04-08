<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function() {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'buy']);
    Route::get('/mypage', [ItemController::class, 'mypageView']);
    Route::get('/mypage/profile', [AuthController::class, 'profileView']);
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'addressView']);
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'addressUpdate']);
    Route::get('/sell', [ItemController::class, 'sellView']);
    Route::post('/sell', [ItemController::class, 'itemRegister']);
    Route::post('/like/{item_id}', [ItemController::class, 'like'])->name('item.like');
    Route::post('/unlike/{item_id}', [ItemController::class, 'unlike'])->name('item.unlike');
});
Route::get('/', [ItemController::class, 'index']);

Route::get('/search', [ItemController::class, 'search']);

Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('detail');

Route::get('/register', [ItemController::class, 'registerView']);

Route::post('/mypage/profile', [AuthController::class,'profileRegister']);
