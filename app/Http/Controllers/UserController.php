<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    use AuthenticatesUsers;
    public function personalInfo($id)
    {
        $data = User::find($id);
       
        return view('UserInfo',['data'=>$data]);
    }

    public function update(Request $request)
    {
        //Added validation 
        $data = User::find ($request->id);
        $validated_data = $request->validate([
            'name' => 'required|max:20',
            'address' => 'required|max:300',
            'phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
        ]);
       $data->fill($validated_data);


        $data -> save();
        return redirect('home'); 
    }
}
