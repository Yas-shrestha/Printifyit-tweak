<?php

use App\Http\Controllers\Api\CartUpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::Post('cart/update/{id}', CartUpdateController::class)->name('api.cart.update');
