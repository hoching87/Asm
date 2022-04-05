<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    use AuthenticatesUsers;
    public function personalInfo()
    {
        /*
        $data = User::find($id);
        return view('UserInfo',['data'=>$data]);*/
        $user = User::find(auth()->id());
        $data = json_decode($user);
        return $data;
    }

    public function getInfo($id)
    {
        $data = User::find($id);
        return view('profile/UpdateProfile',['data'=>$data]);
    }

    public function update(Request $request)
    {
        //Added validation 
        $data = User::find(auth()->id());
        $validated_data = $request->validate([
            'name' => 'required|max:20|min :6',
            'address' => 'required|max:300| min:15',
            'phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
            'email' => 'required | regex:/^[a-zA-Z0-9]+@(?:[a-zA-Z0-9]+\.)+[com]+$/'
        ]);
        
       $data->fill($validated_data);

        $data -> save();
        return $data;
    }
}
