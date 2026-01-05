<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

//Main
Route::get('/', [NavigationController::class, 'index']);
Route::view('/Home', 'welcome')->name('Home');
Route::get('/Product', [NavigationController::class, 'productPage']);
Route::get('/ShoppingCart', [NavigationController::class, 'shoppingCart']);
Route::get('/Profile', [NavigationController::class, 'profilePage'])->middleware('auth');
Route::get('/Products/{tag?}', [NavigationController::class, 'tags'])->name('product.tag');
Route::get('/products', [NavigationController::class, 'search'])->name('product.search');

//Sessions
Route::view('Login', 'login')->name('Login');
Route::post('/login', LoginController::class)->middleware('throttle:5,1')->name('login.attempt');
Route::post('/logout', function () {
    Auth::guard('web')->logout();

    Session::invalidate();
    Session::regenerateToken();

    return redirect('/');
})->name('logout');


Route::view('/Register', 'register')->name('register');
Route::post('/register', RegisterController::class)->name('register.store');
