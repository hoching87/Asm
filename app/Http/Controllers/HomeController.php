<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Bouquet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Bouquet::inRandomOrder()->take(8)->get();
        $blogs = Blog::inRandomOrder()->take(3)->get();

        return view('home', ['products' =>$products, 'blogs' =>$blogs]);
    }
}
