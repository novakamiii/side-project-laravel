<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;


Route::get('/', [NavigationController::class, 'index']);
Route::get('/Product', [NavigationController::class, 'productPage']);
Route::get('/ShoppingCart', [NavigationController::class, 'shoppingCart']);
Route::get('/Profile', [NavigationController::class, 'profilePage']);
Route::get('/Products/{tag?}', [NavigationController::class, 'tags'])->name('product.tag');
Route::get('/products', [NavigationController::class, 'search'])->name('product.search');

