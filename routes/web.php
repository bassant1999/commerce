<?php

use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CommerceController;

// Auth
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

// create listing
Route::get('create', [CommerceController::class, 'create'])->name('create');
Route::post('listCreation', [CommerceController::class, 'listCreation'])->name('listCreation');

// access a listing
Route::get('listing/{listing}', [CommerceController::class, 'listing'])->name('listing');

// watchlist
Route::get('watchlist', [CommerceController::class, 'showWatchlist'])->name('showWatchlist');
Route::get('watchlist/{lid}', [CommerceController::class, 'AddToWatchlist'])->name('watchlist');
Route::get('watchlist/remove/{lid}', [CommerceController::class, 'remove'])->name('remove');

// created list
Route::get('createdList', [CommerceController::class, 'createdList'])->name('createdList');

// category
Route::get('category', [CommerceController::class, 'category'])->name('category');

// bid
Route::post('bid/{lid}', [CommerceController::class, 'bid'])->name('bid');

// comment
Route::post('comment/{lid}', [CommerceController::class, 'comment'])->name('comment');

// profile
Route::get('profile/{uid}', [CommerceController::class, 'profile'])->name('profile');

// inactivate
Route::get('inactivate/{lid}', [CommerceController::class, 'inactivate'])->name('inactivate');

// notifications
Route::get('notifications', [CommerceController::class, 'notifications'])->name('notifications');