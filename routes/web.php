<?php

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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/detail/{slug}', 'DetailController@index')->name('detail');

// checkout
Route::post('/checkout/{id}', 'CheckoutController@process')->name('checkout-process')->middleware(['auth']);
Route::get('/checkout/{id}', 'CheckoutController@index')->name('checkout')->middleware(['auth']);
Route::post('/checkout/create/{detail_id}', 'CheckoutController@create')->name('checkout-create')->middleware(['auth']);
Route::get('/checkout/remove/{detail_id}', 'CheckoutController@remove')->name('checkout-remove')->middleware(['auth']);
Route::get('/checkout/confirm/{detail_id}', 'CheckoutController@success')->name('checkout-success')->middleware(['auth']);

// middleware auth dan admin utk keamanan dari Kernel 
Route::prefix('admin')->namespace('Admin')->middleware('auth', 'admin')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('travel-package', 'TravelPackageController');
    Route::resource('gallery', 'GalleryController');
    Route::resource('transaction', 'TransactionController');
});

Auth::routes([
    'verify' => true,
]);