<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuProductsController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductsController::class);
Route::resource('menus', MenuController::class);
Route::resource('menu_products', MenuProductsController::class);