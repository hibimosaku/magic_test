<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ItemController;
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


Route::get('/', [WelcomeController::class, 'index'])->name('top');
// Route::get('/inquiry', [InquiryController::class, 'index'])->name('inquiry');
Route::get('/guide', function () {
    return view('guide');
})->name('guide');


// verified ミドルウェアは、 Illuminate\Auth\Middleware\EnsureEmailIsVerified クラスで提供されており、このミドルウェアが適用されたルートにアクセスする場合、ログインしているユーザーがメールアドレスの確認を済ませていない場合、そのユーザーは email/verify ページにリダイレクトされます。
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('item')->group(function () {
    Route::get('/', [ItemController::class, 'showAll'])->name('item.showAll');
    Route::get('/category/{primarycategoryid}', [ItemController::class, 'showByPrimaryCategory'])->name('item.showByPrimaryCategory');
    Route::get('/category/{primarycategoryid}/{secondarycategoryid}', [ItemController::class, 'showBySecondaryCategory'])->name('item.showBySecondaryCategory');
    Route::get('/{id}', [ItemController::class, 'show'])->name('item.show');
});


Route::prefix('inquiry')->group(function () {
    Route::get('/', [InquiryController::class, 'index'])->name('inquiry');
    Route::get('/send', [InquiryController::class, 'send'])->name('inquiry.send');
    Route::get('/success', [InquiryController::class, 'success'])->name('inquiry.success');
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('add', [CartController::class, 'add'])->name('cart.add');
    Route::put('cart/{id}/{color}/{size}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/{id}/{color}/{size}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('sessionStripe', [CartController::class, 'sessionStripe'])->name('cart.sessionStripe');
});
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('confirm', [OrderController::class, 'indexConfirm'])->name('order.indexConfirm');
    Route::post('checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::get('success', [OrderController::class, 'success'])->name('order.success');
    Route::get('fail', [OrderController::class, 'fail'])->name('order.fail');
    Route::post('cancel', [OrderController::class, 'cancel'])->name('order.cancel');
});


// authは認証
Route::middleware('auth')->group(function () {
    //nameをつけると呼び出し時使える
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
