<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\EsewaPaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index']);
Route::get('/cart', [FrontendController::class, 'cart']);
Route::get('/shop', [FrontendController::class, 'shop']);
Route::get('/checkout', [FrontendController::class, 'checkout']);
Route::get('/contact', [FrontendController::class, 'contact']);
Route::get('/product', [FrontendController::class, 'product']);
Route::post('/contact-store', [FrontendController::class, 'contactStore'])->name('contact.store');
Route::get('/customize-prod', [FrontendController::class, 'customizeProd']);
Route::get('/prod-detail/{id}', [FrontendController::class, 'prodDetail'])->name('prod.detail');

Route::post('/carts/{id}', [CartController::class, 'index'])->name('carts.store');
Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('carts.destroy');

Route::post('esewa/pay', [EsewaPaymentController::class, 'pay'])->name('esewa.pay');
Route::get('esewa/check', [EsewaPaymentController::class, 'check'])->name('esewa.check');

Route::get('/payment-failed', [FrontendController::class, 'paymentFailed'])->name('payment-failed');



Route::middleware('auth')->prefix('admin')->group(function () {
    Route::post('/update-req-status/{id}', [ProductController::class, 'changeReqStatus'])->name('update.reqStatus');
    Route::post('/update-status/{id}', [ProductController::class, 'changeStatus'])->name('update.status');
    Route::post('/update-price/{id}', [ProductController::class, 'updatePrice'])->name('update.price');
    Route::resource('/product', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/orders', OrdersController::class);
    Route::resource('/file', FileController::class);
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/{id}/show', [ContactController::class, 'show'])->name('contact.show');
    Route::delete('/contact/{id}/delete', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::resource('/carousels', CarouselController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
