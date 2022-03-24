<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function displayInfo($id)
    {
        $data = User::find($id);
        return view('UserInfo',['data'=>$data]);
    }

    public function getInfo($id)
    {
        $data = User::find($id);
        return view('profile/UpdateProfile',['data'=>$data]);
    }

    public function update(Request $request)
    {
        $data = User::find ($request->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        $data -> save();
        return view('UserInfo',['data'=>$data]);
    }
}
