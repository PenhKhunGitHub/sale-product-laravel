<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuantityController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Category Route
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');
Route::get('/category/show',[CategoryController::class,'show'])->name('category.show');
Route::put('/category/edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
Route::put('/category/update/{id}',[CategoryController::class,'update'])->name('category.update');
Route::delete('/category/delete/{id}',[CategoryController::class,'destroy'])->name('category.destroy');
// Product Route
Route::post('/product/store',[ProductController::class,'store'])->name('product.store');
Route::get('/product/show',[ProductController::class,'show'])->name('product.show');
Route::put('/product/edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route::put('/product/update/{id}',[ProductController::class,'update'])->name('product.update');
Route::delete('/product/delete/{id}',[ProductController::class,'destroy'])->name('product.destroy');
// Quantity Route
Route::post('/quantity/store',[QuantityController::class,'store'])->name('quantity.store');
Route::get('/quantity/show',[QuantityController::class,'show'])->name('quantity.show');
Route::put('/quantity/edit/{id}',[QuantityController::class,'edit'])->name('quantity.edit');
Route::put('/quantity/update/{id}',[QuantityController::class,'update'])->name('quantity.update');
Route::delete('/quantity/delete/{id}',[QuantityController::class,'destroy'])->name('quantity.destroy');
// Order Route
Route::post('/order/store',[OrderController::class,'store'])->name('order.store');
Route::get('/order/show',[OrderController::class,'show'])->name('order.show');
Route::put('/order/edit/{id}',[OrderController::class,'edit'])->name('order.edit');
Route::put('/order/update/{id}',[OrderController::class,'update'])->name('order.update');
Route::delete('/order/delete/{id}',[OrderController::class,'destroy'])->name('order.destroy');
