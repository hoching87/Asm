<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BouquetController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

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

// Route::view('/HomePage', 'HomePage');
// Auth::routes();

Route::middleware(['jwtheader'])->group(function () {
  

    //Cart
    // Route::get('/products', [BouquetController::class, 'productList'])->name('products.list');
    //Page for user to fill up order
    Route::get('FillUpOrder', [OrderController::class, 'FillUpOrder'])->name('FillUpOrder');

    Route::get('getcart', [CartController::class, 'cartList'])->name('cart.list');
    Route::post('addToCart', [CartController::class, 'addToCart'])->name('cart.store');
    Route::post('updateCart', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('removeCart', [CartController::class, 'removeCart'])->name('cart.remove');
    Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');

    //Blog
    Route::get('/Blog', [BlogController::class, 'index'])->name('blogs');
});

Route::get('/session', function () {
    // return session()->get('jwt');
    return session()->all();
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

//To know whether got login or not
Route::middleware('jwt')->group(function () {
    Route::get('/login',function(){
        if(auth()->user())
        {
            return redirect('home');
        }
        return view('profile.login');
    })->name('login');

    //User register page if user already login then redirect them to home page
    Route::get('/register',function(){
        if(auth()->user())
        {
            return redirect('home');
        }
        return view('profile.register');
    })->name('register');

    //Public page if user already login then redirect them to home page
    Route::get('/home',function(){
        if(auth()->user())
        {
            return view('home');
        }
        return view('profile.login');
    })->name('home');

     //Public page if user not login then redirect them to login page
    Route::get('/userinfo',function(){
        if(auth()->user())
        {
            return view('userinfo');
        }
        return view('profile.login');
    })->name('userinfo');

    //Page for user to access only
    Route::group(['middleware' => ['UserPage']], function () {
    Route::view('/cart', 'cart'); 
    Route::view('/orders', 'orders');
    Route::view('/products', 'products');
    });
    
    //Page for admin to register, if want register admin type in key=qwe123 in url -> example: <http://127.0.0.1:8000/AdminRegister?key=qwe123>
    Route::group(['middleware' => ['AdminRegister']], function () {
    Route::view('/AdminRegister', 'Admin/AdminRegister');
    });

    //Page for admin to access only
    Route::group(['middleware' => ['AdminPage']], function () {
    Route::view('/AdminOrder', 'Admin/AdminOrder')->name('AdminOrder');
    Route::view('/AddBouquet', 'Admin/AddBouquet')->name('AddBouquet');
    Route::view('/editProducts', 'EditProducts');
    });
   
    
});
