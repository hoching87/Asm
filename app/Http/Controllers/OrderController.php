<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;
use App\Models\Bouquet;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class OrderController extends Controller
{
    use AuthenticatesUsers;

    
    //For Admin to view All Orders
    public function AdminViewOrderList()
    {
        $orders = Order::all()->toJson();
        $orders = json_decode($orders);
        $orders = array_map(function ($order) {
            $order->items = array_map(function ($item) {
                $item->details = Bouquet::find($item->id);
                return $item;
            }, $order->items);
            return $order;
        }, $orders);
        return $orders;
    }

    //For user view their own order
    public function userViewOrderList()
    {
        $orders = User::find(auth()->id())->getOrders->toJson();
        $orders = json_decode($orders);

        // Add items details
        $orders = array_map(function ($order) {
            $order->items = array_map(function ($item) {
                $item->details = Bouquet::find($item->id);
                return $item;
            }, $order->items);
            return $order;
        }, $orders);

        return $orders;
    }

    //User enter order details, then insert data into orders and order_details table
    public function ConfirmOrder(Request $req)
    {
        //validation
        $validated_data = $req->validate([
            'reciever_name' => 'required|max:50|min:10',
            'reciever_address' => 'required|max:300| min:10',
            'reciever_phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
        ]);

        $order = new Order;
        $order->status = 'pending';
        $order->user_id = Auth::id();
        $order->date_ordered = Carbon::now();
        $order->items = $req->cart;
        $order->reciever_name = $req->reciever_name;
        $order->reciever_address = $req->reciever_address;
        $order->reciever_phone = $req->reciever_phone;

        $order->save();
        return $order;
    }

    //Admin accept orders placed by users
    public function AcceptOrder(Request $req)
    {
        $date = Carbon::now()->format('Y-m-d');
        $order = Order::find($req -> id);
        $order -> status = 'delivered';
        $order -> date_delivered = $date;
        $order->save();

        return $order;
    }

    //User delete orders and set the status become cancell
    public function DeleteOrder(Request $req)
    {
        // $user_id = Auth::id();
        // $DeleteOrder = DB::delete("Delete FROM orders where order_id = $order_id");
        // $DeleteOrderDetails = DB::delete("Delete FROM order_details where order_id = $order_id");

        // $orderList = Order::all();
        // return view('layouts.order', ['orderList' => $orderList]);

        $order = Order::find($req -> id);
        $order -> status = 'cancel';
        $order->save();
        return $order;
    }

    //show edit orders page to users
    // public function ShowEditOrder($order_id)
    // {
    //     $orderList = DB::select("select * FROM orders where order_id =$order_id ");

    //     return view('layouts.showEditOrder', ['orderList' => $orderList]);
    // }

    // //User confirm edit orders
    // public function EditOrder($order_id, Request $req)
    // {
    //     $date = Carbon::now()->format('Y-m-d');

    //     $validated_data = $req->validate([
    //         'reciever_name' => 'required|max:20',
    //         'reciever_address' => 'required|max:300',
    //         'reciever_phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
    //     ]);
    //     $order = DB::update("Update orders SET reciever_name='$req->reciever_name',reciever_address='$req->reciever_address',reciever_phone='$req->reciever_phone' where order_id =$order_id ");

    //     $orderList = Order::all();
    //     return view('layouts.order', ['orderList' => $orderList]);
    // }
}
