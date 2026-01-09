<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

//Main
Route::get('/', [NavigationController::class, 'index']);
Route::view('/Home', 'welcome')->name('Home');
Route::get('/Product', [NavigationController::class, 'productPage']);
// Route::get('/ShoppingCart', [NavigationController::class, 'shoppingCart']);
Route::view('/ShoppingCart', 'shopping-cart');

// Cart Routes (Protected with auth middleware)
Route::middleware('auth')->group(function () {
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'getCart'])->name('cart.get');
    Route::delete('/cart/{cartItemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::patch('/cart/{cartItemId}', [CartController::class, 'updateQuantity'])->name('cart.update');
});


Route::get('/Products/{tag?}', [NavigationController::class, 'tags'])->name('product.tag');
Route::get('/products', [NavigationController::class, 'search'])->name('product.search');

//Sessions
Route::get('/Profile', UserController::class)
    ->middleware('auth')
    ->name('profile.show');
Route::patch('/profile', [UserController::class, 'changeDetails'])
    ->middleware('auth')
    ->name('profile.update');
Route::patch('/profile-change', [UserController::class, 'changeProfilePicture'])
    ->middleware('auth')
    ->name('profile.change');

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
