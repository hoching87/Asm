<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouquet;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Support\Facades\Validator;

class BouquetController extends Controller
{

    public function index()
    {
        $products = Bouquet::all();
        // $types = Bouquet::all();

        // return view('Bouquet', ['products' =>$products,'types' =>$types]);
        return $products;
    }

    //Products.blade.php
    public function productList()
    {
        $products = Bouquet::all();
        $types = Bouquet::all();
        return view('layouts.products', ['products' => $products, 'types' => $types]);
    }

    public function type($type = null, $sort = null)
    {
        $types = Bouquet::all();
        $products = Bouquet::all();

        if (Bouquet::where('type', $type)->exists()) {
            $products = Bouquet::where('type', $type)->get();
            return view('Bouquet', ['products' => $products, 'types' => $types]);
        }

        if (request()->sort == 'low_high') {
            $products = $products->sortBy('bouequetPrice');
            return view('Bouquet', ['products' => $products, 'types' => $types]);
        } else if (request()->sort == 'high_low') {
            $products = $products->sortByDesc('bouequetPrice');
            return view('Bouquet', ['products' => $products, 'types' => $types]);
        } else if (request()->sort == 'Newest') {
            $products = $products->sortByDesc('id');
            return view('Bouquet', ['products' => $products, 'types' => $types]);
        } else {
            return redirect('Bouquet');
        };
    }
    public function create()
    {
        if (Gate::allows('isAdmin')) {
            dd('Admin allowed');
        } else {
            dd('You are not an Admin');
        }
    }

    public function addBouquet()
    {
        if (Gate::allows('isAdmin')) {
            return view('bouquets.create');
        } else {
            return view('unauthorized');
        }
    }



    public function edit($id)
    {
        if (Gate::allows('isAdmin')) {
            $bouquet = Bouquet::find($id);
            return view('bouquets.edit', ['bouquet' => $bouquet]);
        } else {
            return view('unauthorized');
        }
    }

    public function delete()
    {
        if (Gate::allows('isAdmin')) {
            dd('Admin allowed');
        } else {
            dd('You are not Admin');
        }
    }

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

    public function destroy($id)
    {
        $bouquet = Bouquet::find($id);
        $bouquet->delete();
        return redirect('Bouquet');
    }

    public function update(Bouquet $bouquet, Request $request)
    {

        //Validation for data input
        $validated_data = $request->validate([
            'bouequetName' => 'required|max:20',
            'bouequetDescription' => 'required|max:300',
            'bouequetPrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',

        ]);
        //Find the Bouquet according to ID
        $data = Bouquet::findOrFail($request->id);
        if ($request->hasfile('bouquetImage')) {
            $file = $request->file('bouquetImage');
            $extension = $file->getClientOriginalExtension(); //getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/images/', $filename);
            $data->bouquetImage = $filename;
        }

        if ($request->has('type')) {
            $data->type = $request->type;
        }
        //Fill Up if all data valid
        $data->fill($validated_data);
        $data->save();
        return redirect('home');
    }

    public function createBouquet(Request $request)
    {
        //Remove the if condition for Gate, since the middelware can help us to do the checking
        //Added validation part for this as well
        $bouquet = new Bouquet();

        $validated_data = $request->validate([
            'bouequetName' => 'required|max:20',
            'bouequetDescription' => 'required|max:300',
            'bouequetPrice' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'type' => 'required'
            

        ]);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName(); //getting image extension
            $extension = $file->getClientOriginalExtension();

            $picture = time() . '.' . $filename;
            $file->move('uploads/images/', $picture);
            $bouquet->bouquetImage = $picture;
        } else {
            $bouquet->bouquetImage = 'No Pic';
        }
        //Same logic
       
        $bouquet->fill($validated_data);
        $bouquet->save();
       
        return $bouquet;
    }
}
