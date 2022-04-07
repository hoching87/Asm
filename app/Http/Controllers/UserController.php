<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
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
            'phone' => 'required|regex:/^(601)[0-46-9]*[0-9]{7,8}$/|digits:11',
        ]);
        if($data->email == $request->email){
            $data->fill($validated_data);
        }
        else
        {
            $validated_data = $request->validate([
                'name' => 'required|max:20|min :6',
                'address' => 'required|max:300| min:15',
                'phone' => 'required|regex:/^(601)[0-46-9]*[0-9]{7,8}$/|digits:11',
                'email' => 'required | regex:/^[a-zA-Z0-9]+@(?:[a-zA-Z0-9]+\.)+[com]+$/|unique:users'
            ]);
            $data->fill($validated_data);
        }
       

        $data -> save();
        return $data;
    }

    public function delete(Request $req)
    {
        // $user_id = Auth::id();
        // $DeleteOrder = DB::delete("Delete FROM orders where order_id = $order_id");
        // $DeleteOrderDetails = DB::delete("Delete FROM order_details where order_id = $order_id");

        // $orderList = Order::all();
        // return view('layouts.order', ['orderList' => $orderList]);
        
         $id =$req->id;
        $deleteOrders = DB::delete("Delete FROM orders where user_id = $id ");
     
        $user = User::find($req -> id);
        $user -> delete();
       
    }
}
