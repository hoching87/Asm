<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Bouquet::inRandomOrder()->take(8)->get();
        $blogs = Blog::inRandomOrder()->take(3)->get();

        return ['products' => $products, 'blogs' => $blogs];
    }
}
