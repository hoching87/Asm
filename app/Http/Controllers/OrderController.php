<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails;
class OrderController extends Controller
{
    //For Admin to view All Orders
    public function AdminViewOrderList()
    {
        $orderList = DB::select("select * from orders");
        
        return view('layouts.order', ['orderList' => $orderList]);
       
    }

    //For user view their own order
    public function userViewOrderList()
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
        $orderDetail = DB::select("select * from order_details where order_id=$order_id");
        return view('layouts.orderDetail', ['order' => $order, 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }

    public function checkout($order_id)
    {
        $order = DB::select("select * from orders where order_id=$order_id");
        $orderDetail = DB::select("select * from order_details where order_id=$order_id");
        return view('layouts.orderDetail', ['order' => $order, 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }


    public function FillUpOrder()
    {
        $cartItems = \Cart::getContent();
       return view('FillUpOrder', compact('cartItems'));
    }

    
    public function ConfirmOrder()
    {
        $date = Carbon::now()->format('Y-m-d');
        
        $cartItems = \Cart::getContent();
        $user_id = Auth::id();
        $order = new Order;
        $orderProducts = new OrderDetails;

        $order->status = 'pending';
        $order->user_id = $user_id;
        $order->date_ordered = $date;

        $order->save();
       
        $orderProducts = [];
        foreach ($cartItems as $items ) {
            $orderProducts[] = [
                'order_id' => $order->id,
                'item_id' => $items['id'],
                'quantity' => $items['quantity'],
                'price' => $items['price'],
            ];
        }
        OrderDetails::insert($orderProducts);
        \Cart::clear();
       
        $orderList = DB::select("select * from orders where user_id=$user_id");
        return view('layouts.order', ['orderList' => $orderList]);

    }

    public function AcceptOrder($order_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $user_id = Auth::id();
        
        $order = DB::update("Update orders SET status='delivered', date_delivered ='$date' where order_id =$order_id ");

       

        $orderList = Order::all();
        return view('layouts.order', ['orderList' => $orderList]);
    }
    
}
