<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

Route::middleware('auth', 'verified')->group(function() {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase');
    Route::post('/purchase/{item_id}', [ItemController::class, 'buy'])->name('purchase.buy');
    Route::get('/mypage', [ItemController::class, 'mypageView'])->name('mypage');
    Route::get('/mypage/profile', [AuthController::class, 'profileView']);
    Route::post('/mypage/profile', [AuthController::class,'profileRegister']);
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'addressView']);
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'addressUpdate']);
    Route::get('/sell', [ItemController::class, 'sellView']);
    Route::post('/sell', [ItemController::class, 'itemRegister']);
    Route::post('/like/{item_id}', [ItemController::class, 'like'])->name('item.like');
    Route::post('/unlike/{item_id}', [ItemController::class, 'unlike'])->name('item.unlike');
    Route::post('/comments/{item_id}', [ItemController::class, 'comment']);
    Route::get('/success', function () {
        return view('success');
    })->name('purchase.success');
    Route::get('cancel', function () {
        return view('cancel');
    })->name('purchase.cancel');
});
Route::get('/', [ItemController::class, 'index'])->name('index');

Route::get('/search', [ItemController::class, 'search']);

Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('detail');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // 認証完了
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/test-mail',function () {
    Mail::raw('テストメール', function ($message) {
    $message->to('test@example.com')
            ->subject('Mailhogテスト');
    });
    return 'メールを送信しました';
});
