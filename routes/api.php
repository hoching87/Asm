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

Route::get('/home', [HomeController::class, 'index']);
Route::get('/orders', [OrderController::class, 'userViewOrderList']);
Route::get('/adminViewOrders', [OrderController::class, 'AdminViewOrderList']);

Route::get('/products', [BouquetController::class, 'index']);
Route::post('/comfirmorder', [OrderController::class, 'ConfirmOrder']);
Route::get('PersonalInfo', [UserController::class, 'personalInfo'])->name('PersonalInfo');
Route::post('/update', [UserController::class, 'update']);
Route::post('/DeleteOrder', [OrderController::class, 'DeleteOrder'])->name('DeleteOrder');
Route::post('/AcceptOrder', [OrderController::class, 'AcceptOrder'])->name('AcceptOrder');
Route::post('/createBouquet', [BouquetController::class, 'createBouquet'])->name('createBouquet');


