<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuantityController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('admin/index');
})->name('home');
Route::get('/register', function () {
    return view('admin/register');
});

//====> Header Page <====
Route::get('/header', function () {
    return view('header');
})->name('header');
//====> Footer Page <====
Route::get('/footer', function () {
    return view('footer');
})->name('footer');

//====> About Page <====
Route::get('/category',[CategoryController::class,'index'])->name('category');
Route::get('/product',[ProductController::class,'index'])->name('product');
Route::get('/quantity',[QuantityController::class,'index'])->name('quantity');
Route::get('/order',[OrderController::class,'index'])->name('order');
Route::get('/order_detail',[OrderDetailController::class,'index'])->name('order_detail');

