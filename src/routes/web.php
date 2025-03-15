<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

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
Route::get('/', [ItemController::class, 'index']);

Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);

Route::get('/login', [ItemController::class, 'loginView']);

Route::get('/register', [ItemController::class, 'registerView']);

Route::get('/mypage/profile', [ItemController::class, 'profileRegister']);

Route::get('/sell', [ItemController::class, 'sellView']);

Route::get('/purchase/address/{item_id}', [ItemController::class, 'addressView']);