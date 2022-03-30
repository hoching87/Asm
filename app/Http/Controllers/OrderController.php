<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails;
use App\Models\Blog;
use App\Models\Bouquet;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class OrderController extends Controller
{
    use AuthenticatesUsers;
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
        if(Auth::user()->id != $user_id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);

        }
        $orderList = DB::select("select * from orders where user_id=$user_id");
        return view('layouts.order', ['orderList' => $orderList]);
        // return $orderList;
        // return Auth::id();
    }

    
    public function orderDetail($id, Request $req)
    {
       
        $orderDetail = DB::select("select * from order_details where order_id='$req->order_id'");
        
        return view('layouts.orderDetail', [ 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }

    public function checkout($order_id)
    {
        $order = DB::select("select * from orders where order_id=$order_id");
        $orderDetail = DB::select("select * from order_details where order_id=$order_id");
        return view('layouts.orderDetail', ['order' => $order, 'orderDetail' => $orderDetail]);
        // return $orderDetail;
    }

    //link users to page of insert order details
    public function FillUpOrder()
    {
        $cartItems = \Cart::getContent();
       return view('FillUpOrder', compact('cartItems'));
    }

    //User enter order details, then insert data into orders and order_details table
    public function ConfirmOrder(Request $req)
    {
        $date = Carbon::now()->format('Y-m-d');
        
        $cartItems = \Cart::getContent();
        $user_id = Auth::id();
        $order = new Order;
        $orderProducts = new OrderDetails;

        //Added the validation part as well
        $validated_data = $req->validate([
            'reciever_name' => 'required|max:20',
            'reciever_address' => 'required|max:300',
            'reciever_phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
        ]);
        $order->status = 'pending';
        $order->user_id = $user_id;
        $order->date_ordered = $date;
        $order->total_price = \Cart::getTotal();
    

        $order->fill($validated_data);

        $order->save();
       
        $orderProducts = [];
        foreach ($cartItems as $items ) {
            $orderProducts[] = [
                'order_id' => $order->id,
                'item_id' => $items['id'],
                'quantity' => $items['quantity'],
                'price' => $items['price'],
                'image' => $items['attributes'],

            ];
        }
        OrderDetails::insert($orderProducts);
        \Cart::clear();

        
        $products = Bouquet::inRandomOrder()->take(8)->get();
        $blogs = Blog::inRandomOrder()->take(3)->get();

        return view('home', ['products' =>$products, 'blogs' =>$blogs]);

    }

    //Admin accept orders placed by users
    public function AcceptOrder($order_id)
    {
        $date = Carbon::now()->format('Y-m-d');
        $user_id = Auth::id();
        
        $order = DB::update("Update orders SET status='delivered', date_delivered ='$date' where order_id =$order_id ");

       

        $orderList = Order::all();
        return view('layouts.order', ['orderList' => $orderList]);
    }

       //User delete orders 
       public function DeleteOrder($order_id)
       {
           
           $user_id = Auth::id();
           
           $DeleteOrder = DB::delete("Delete FROM orders where order_id = $order_id");
           $DeleteOrderDetails = DB::delete("Delete FROM order_details where order_id = $order_id");

          
   
           $orderList = Order::all();
           return view('layouts.order', ['orderList' => $orderList]);
       }

    //show edit orders page to users
    public function ShowEditOrder($order_id)
    {
     
        
        $orderList = DB::select("select * FROM orders where order_id =$order_id ");

       
        return view('layouts.showEditOrder', ['orderList' => $orderList]);
    }

    //User confirm edit orders
    public function EditOrder($order_id, Request $req)
    {
        $date = Carbon::now()->format('Y-m-d');
        
        $validated_data = $req->validate([
            'reciever_name' => 'required|max:20',
            'reciever_address' => 'required|max:300',
            'reciever_phone' => 'required|regex:/(\+?6?01)[0-46-9]-*[0-9]{7,8}/',
        ]);
        $order = DB::update("Update orders SET reciever_name='$req->reciever_name',reciever_address='$req->reciever_address',reciever_phone='$req->reciever_phone' where order_id =$order_id ");

       

        $orderList = Order::all();
        return view('layouts.order', ['orderList' => $orderList]);
    }
    
}
