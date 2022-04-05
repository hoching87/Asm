<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BouquetController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
//Homepage
Route::get('/home', [HomeController::class, 'index']);
//User view own orders
Route::get('/orders', [OrderController::class, 'userViewOrderList']);
//Admin view all orders request by users
Route::get('/adminViewOrders', [OrderController::class, 'AdminViewOrderList']);
//Retireve all bouquet
Route::get('/products', [BouquetController::class, 'index']);
//User confirm the order and checkout the cart list
Route::post('/comfirmorder', [OrderController::class, 'ConfirmOrder']);
//View personal information
Route::get('PersonalInfo', [UserController::class, 'personalInfo'])->name('PersonalInfo');
//Update personal information
Route::post('/update', [UserController::class, 'update']);
//User delete order
Route::post('/DeleteOrder', [OrderController::class, 'DeleteOrder'])->name('DeleteOrder');
//Admin accept order
Route::post('/AcceptOrder', [OrderController::class, 'AcceptOrder'])->name('AcceptOrder');
//Add new bouquet
Route::post('/createBouquet', [BouquetController::class, 'createBouquet'])->name('createBouquet');
//Update bouquet
Route::post('/UpdateBouquet', [BouquetController::class, 'update']);
//Admin delete bouquet
Route::post('/DeleteBouquet', [BouquetController::class, 'destroy'])->name('BouquetController');

