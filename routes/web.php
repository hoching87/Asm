<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BouquetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::view('/HomePage', 'HomePage');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
Route::get('/register/user', [RegisterController::class, 'showRegisterForm']);

Route::get('/Bouquet', [BouquetController::class, 'index'])->name('bouquets');
Route::get('/AddBouquet', [BouquetController::class, 'addBouquet']);
Route::get('bouquets-type/{type?}', [BouquetController::class, 'type'])->name('bouquets-type');
Route::get('bouquets-price/{sort?}', [BouquetController::class, 'type'])->name('bouquets-price');
Route::get('PersonalInfo/{id}', [UserController::class, 'personalInfo'])->name('PersonalInfo');
Route::put('/UserUpdate/{id}', [UserController::class, 'update']);


Route::post('/createBouquet', [BouquetController::class, 'createBouquet']);
Route::post('/Bouquet/{id}', [BouquetController::class, 'edit']);
Route::put('/Bouquet/{id}', [BouquetController::class, 'update']);
Route::delete('/Bouquet/{id}', [BouquetController::class, 'destroy']);

Route::resources([
    'bouquets' => BouquetController::class,

]);

//Cart
Route::get('/products', [BouquetController::class, 'productList'])->name('products.list');
Route::post('order', [OrderController::class, 'FillUpOrder'])->name('order');

Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

//order
Route::get('/orders', [OrderController::class, 'orderList']);
Route::get('/orders/{id}', [OrderController::class, 'orderDetail'])->name('orders');
asdasdas
