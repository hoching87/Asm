<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Facades\Storage;
use Auth;

class BlogController extends Controller
{
    
    public function index()
    {
        $blogs = Blog::all();
      
        return view('Blog', ['blogs' =>$blogs]);
    }

}
