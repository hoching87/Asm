<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BouquetController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BlogController;
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
Route::get('bouquets-type/{type?}', [BouquetController::class, 'type'])->name('bouquets-type');
Route::get('bouquets-price/{sort?}', [BouquetController::class, 'type'])->name('bouquets-price');
Route::put('/UserUpdate/{id}', [UserController::class, 'update']);



Route::resources([
    'bouquets' => BouquetController::class,
]);

//Cart
Route::get('/products', [BouquetController::class, 'productList'])->name('products.list');
//Page for user to fill up order
Route::get('FillUpOrder', [OrderController::class, 'FillUpOrder'])->name('FillUpOrder');

Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

//Blog
Route::get('/Blog', [BlogController::class, 'index'])->name('blogs');

//Middleware to check the account got the right to access to some pages or not
Route::group(['middleware' => ['protectedPage']], function () {
    Route::get('PersonalInfo/{id}', [UserController::class, 'personalInfo'])->name('PersonalInfo');
    Route::post('/orders/{id}', [OrderController::class, 'orderDetail'])->name('orders');
    Route::get('/AddBouquet', [BouquetController::class, 'addBouquet'])->name('AddBouquet');
    Route::get('/AdminViewOrderList', [OrderController::class, 'AdminViewOrderList'])->name('AdminViewOrders');
    Route::put('AcceptOrder/{order_id}', [OrderController::class, 'AcceptOrder'])->name('AcceptOrder');
    Route::delete('/Bouquet/{id}', [BouquetController::class, 'destroy']);
    //Bouquet
    Route::post('/createBouquet', [BouquetController::class, 'createBouquet']);
    Route::get('/UpdateBouquet/{id}', [BouquetController::class, 'edit'])->name('showUpdate');
    Route::post('/UpdateBouquet/{id}', [BouquetController::class, 'update'])->name('updateBouquet');
});

//Middleware to check the account got the right to access to some pages or not
Route::group(['middleware' => ['protectedPage2']], function () {
    //order
    Route::get('/userViewOrderList', [OrderController::class, 'userViewOrderList'])->name('UserViewOrders');
    Route::post('ConfirmOrder', [OrderController::class, 'ConfirmOrder'])->name('ConfirmOrder');
    //Delete function for user only
    Route::delete('DeleteOrder/{order_id}', [OrderController::class, 'DeleteOrder'])->name('DeleteOrder');
    //Show edit page  for user only
    Route::get('/ShowEditOrder/{order_id}', [OrderController::class, 'ShowEditOrder'])->name('ShowEditOrder');
    //Confirm edit by user
    Route::post('/EditOrder/{order_id}', [OrderController::class, 'EditOrder'])->name('EditOrder');
});

//order
Route::get('/orders', [OrderController::class, 'orderList']);
Route::get('/orders/{id}', [OrderController::class, 'orderDetail'])->name('orders');

