<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderList()
    {
        $user_id = Auth::id();
        $orderList = DB::select("select * from orders where user_id=$user_id");
        return view('layouts.order', ['orderList' => $orderList]);
        // return $orderList;
        // return Auth::id();
    }

    public function orderDetail($order_id)
    {
        $order = DB::select("select * from orders where order_id=$order_id");
        $orderDetail = DB::select("select * from orders_details where order_id=$order_id");
        return view('layouts.orderDetail', ['order' => $order, 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }

    public function checkout($order_id)
    {
        $order = DB::select("select * from orders where order_id=$order_id");
        $orderDetail = DB::select("select * from orders_details where order_id=$order_id");
        return view('layouts.orderDetail', ['order' => $order, 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }
}
