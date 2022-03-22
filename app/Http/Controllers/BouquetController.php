<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouquet;
use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Facades\Storage;
use Auth;

class BouquetController extends Controller
{
    
    public function index()
    {
        $products = Bouquet::all();
        $types = Bouquet::all();
      
        return view('Bouquet', ['products' =>$products,'types' =>$types]);
    }

     //Products.blade.php
     public function productList()
     {
         $products = Bouquet::all();
         $types = Bouquet::all();
         return view('layouts.products', ['products' =>$products,'types' =>$types]);
     }

    public function type($type=null, $sort=null)
    {
        $types = Bouquet::all();
        $bouquet = Bouquet::all();

        if(Bouquet :: where ('type', $type)->exists())
        {
            $bouquet = Bouquet :: where ('type', $type)->get();
            return view('Bouquet', ['bouquet'=>$bouquet,'types' =>$types]);
        }
        
        if (request()->sort == 'low_high') {
            $bouquet = $bouquet->sortBy('bouequetPrice');
            return view('Bouquet', ['bouquet'=>$bouquet,'types' =>$types]);

        } else if (request()->sort == 'high_low') {
            $bouquet = $bouquet->sortByDesc('bouequetPrice');
            return view('Bouquet', ['bouquet'=>$bouquet,'types' =>$types]);

        } else if (request()->sort == 'Newest') {
            $bouquet = $bouquet->sortByDesc('id');
            return view('Bouquet', ['bouquet'=>$bouquet,'types' =>$types]);

        }
        else
        {
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
        if (Gate::allows('isAdmin')) 
        {
            return view('bouquets.create');
        } 
        else 
        {
            return view('unauthorized');
        }               
    } 
    
   

    public function edit($id) 
    {   
        if (Gate::allows('isAdmin'))
         {
            $bouquet = Bouquet::findOrFail($id);
            return view('bouquets.edit', ['bouquet' => $bouquet]);
        } 
        else 
        {
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
        $bouquet=Bouquet::find($id);
        $bouquet->delete();
        return redirect('Bouquet');
    }

    public function update(Bouquet $bouquet, Request $request)
    {
        $data = Bouquet::find ($request->id);
        $data->bouequetName = $request->bouequetName;
        $data->bouequetDescription = $request->bouequetDescription;
        $data->bouequetPrice = $request->bouequetPrice;
        

        $data->Quantity = $request->Quantity;
        if($request->hasfile('bouquetImage')) {
            $file = $request->file('bouquetImage');
            $extension = $file->getClientOriginalExtension(); //getting image extension
            $filename = time().'.'.$extension;
            $file->move('uploads/images/', $filename);
            $data->bouquetImage = $filename;
        }

        if($request->has('type')) {
            $data->type = $request->type;

        }


        $data -> save();
        return redirect('home'); 
    }

    public function createBouquet(Request $request) 
    { 
        if (Gate::allows('isAdmin')) {
            $bouquet = new Bouquet();

           
            if($request->hasfile('bouquetImage')) {
                $file = $request->file('bouquetImage');
                $extension = $file->getClientOriginalExtension(); //getting image extension
                $filename = time().'.'.$extension;
                $file->move('uploads/images/', $filename);
                $bouquet->bouquetImage = $filename;
            } else {
                $bouquet->bouquetImage = '';
            }
            
            $bouquet->bouequetName = $request->bouequetName;
            $bouquet->bouequetDescription = $request->bouequetDescription;
            $bouquet->bouequetPrice = $request->bouequetPrice;
            $bouquet->Quantity = $request->Quantity;
            $bouquet->type = $request->type;

            $bouquet->save();

            return redirect('home'); 
        } else {
            return view('unauthorized');
        }              
    } 
}
