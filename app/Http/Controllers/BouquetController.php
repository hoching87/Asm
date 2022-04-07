<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouquet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
class BouquetController extends Controller
{
    //Products.blade.php
    // public function productList()
    // {
    //     $products = Bouquet::all();
    //     $types = Bouquet::all();
    //     return view('layouts.products', ['products' => $products, 'types' => $types]);
    // }

    // public function create()
    // {
    //     if (Gate::allows('isAdmin')) {
    //         dd('Admin allowed');
    //     } else {
    //         dd('You are not an Admin');
    //     }
    // }

    // public function addBouquet()
    // {
    //     if (Gate::allows('isAdmin')) {
    //         return view('bouquets.create');
    //     } else {
    //         return view('unauthorized');
    //     }
    // }



    // public function edit($id)
    // {
    //     if (Gate::allows('isAdmin')) {
    //         $bouquet = Bouquet::find($id);
    //         return view('bouquets.edit', ['bouquet' => $bouquet]);
    //     } else {
    //         return view('unauthorized');
    //     }
    // }

    // public function delete()
    // {
    //     if (Gate::allows('isAdmin')) {
    //         dd('Admin allowed');
    //     } else {
    //         dd('You are not Admin');
    //     }
    // }

    /*
    public function show($id)
    {
        $posts = Post::findOrFail($id);
        return view('post.show', ['posts'=>$posts]);

    }
    */
    /*
    public function show()
    {
        $bouquets = Post::all();
        return view('ShowUserBouquet', ['bouquets'=>$bouquets]);

    }
    */

    public function type(Request $request)
    {
        $types = Bouquet::all();
        $products = Bouquet::all();

        if (Bouquet::where('type', $request->type)->exists()) {
            $products = Bouquet::where('type', $request->type)->get();
            return view('Bouquet', ['products' => $products, 'types' => $types]);
        }

        if (request()->price == 'Low_High') {
            
            $products = Bouquet::orderBy('bouequetPrice')->get(); 
            
            return $products;
        } else if (request()->price == 'High_Low') {
            $products = Bouquet::orderByDesc('bouequetPrice')->get(); 
            return $products;
        } else if (request()->price == 'Newest') {
            $products = Bouquet::orderByDesc('id')->get(); 
            
            return $products;
        } else {
            return $products;
        };
    }
    
    public function index()
    {
        $products = Bouquet::all();
        // $types = Bouquet::all();

        // return view('Bouquet', ['products' =>$products,'types' =>$types]);
        return $products;
    }

    public function destroy(Request $request)
    {
        $bouquet = Bouquet::find($request ->id);
        $bouquet->delete();
        return $bouquet;
    }

    public function update(Request $request)
    {
        // return $request->id;
        //Validation for data input
        $validated_data = $request->validate([
            'bouequetName' => 'required|max:20| min:5',
            'bouequetDescription' => 'required|max:300| min:5',
            'bouequetPrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);
        //Find the Bouquet according to ID
        $data = Bouquet::find($request->id);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName(); //getting image extension
            $extension = $file->getClientOriginalExtension();

            $picture = time() . '.' . $filename;
            $file->move('uploads/images/', $picture);
            $data->bouquetImage = $picture;
        } 

        if ($request->has('type')) {
            $data->type = $request->type;
        }
        //Fill Up if all data valid
        $data->fill($validated_data);
        $data->save();
        return 'ok';
    }

    public function createBouquet(Request $request)
    {
        //Remove the if condition for Gate, since the middelware can help us to do the checking
        //Added validation part for this as well
        $bouquet = new Bouquet();

        $validated_data = $request->validate([
            'bouequetName' => 'required|max:20|min:5',
            'bouequetDescription' => 'required|max:300|min:5',
            'bouequetPrice' => 'required|regex:/^\d+(\.\d{1,2})?$/|numeric',
            'type' => 'required',
            'image' => 'required'

        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName(); //getting image extension
            $extension = $file->getClientOriginalExtension();

            $picture = time() . '.' . $filename;
            $file->move('uploads/images/', $picture);
            $bouquet->bouquetImage = $picture;
        }
        //Same logic
       
        $bouquet->fill($validated_data);
        $bouquet->save();
       
        return $bouquet;
    }
}
