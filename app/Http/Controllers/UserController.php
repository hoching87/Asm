<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function personalInfo($id)
    {
        $data = User::find($id);
        return view('UserInfo',['data'=>$data]);
    }

    public function update(Request $request)
    {
        $data = User::find ($request->id);
        $data->name = $request->name;
        $data->phone = $request->phone;

        $data->address = $request->address;


        $data -> save();
        return redirect('home'); 
    }
}
