@extends('layouts.frontend')

@section('content')
<main class="my-8">
    <div class="container px-6 mx-auto">
        <div class="flex justify-center my-6">
            <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                @if ($message = Session::get('success'))
                <div class="p-4 mb-3 bg-green-400 rounded">
                    <p class="text-green-800">{{ $message }}</p>
                </div>
                @endif
                <h3 class="text-3xl text-bold">Order List

                </h3>
                <div class="flex-1">
                    <table class="w-full text-sm lg:text-base" cellspacing="0">
                        <thead>
                            <tr class="h-12 uppercase">
                                <th class="hidden md:table-cell"></th>
                                <th class="text-left">Order ID</th>
                                <th class="text-left">Status</th>
                                <th class="text-left">User ID</th>
                                <th class="text-left">Date Ordered</th>
                                <th class="text-left">Date Delivered</th>
                                <!-- Added total price, reciever, address, and phone-->
                                <th class="text-left">Total Price</th>
                                <th class="text-left">Reciever</th>
                                <th class="text-left"> Address</th>
                                <th class="text-left"> Phone</th>
                                <th class="text-left">Operation</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderList as $list)
                            <tr>
                                <td class="hidden pb-4 md:table-cell">
                                    <a href="#">

                                    </a>
                                </td>
                                <td>
                                    <a href="#" >
                                        <p class="mb-2 md:ml-4">{{ $list->order_id }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->status }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->user_id  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->date_ordered  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->date_delivered  }}</p>
                                    </a>
                                </td>
                                <!-- Added total price, reciever, address, and phone-->
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->total_price  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->reciever_name  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->reciever_address  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $list->reciever_phone  }}</p>
                                    </a>
                                </td>
                                <td>
                                    
                                    <span class="text-sm font-medium lg:text-base">
                                  
                                         <!-- Able to view the details of order-->
                                        <form method="POST" action="{{route('orders',['id'=>$list->user_id]) }}">
                                            @csrf
                                            <input type="hidden" name='order_id' value="{{ $list->order_id  }}" />

                                            <input type="submit" class="spring-btn btn-lg btn-block" value="View" />

                                        </form>
                                        <br>  <br>
                                        @can('isAdmin')
                                        <form method="POST" action="{{route('AcceptOrder',['order_id'=>$list->order_id]) }}">
                                            @csrf
                                            @method('PUT')
                                            <!-- Only if status pending then accept button display-->
                                            @if($list->status == 'pending')
                                            <input type="submit" class="spring-btn btn-lg btn-block" value="Accept" />
                                            @endif

                                        </form>
                                        @endcan
                                        <!-- Only if status pending then edit, delete buttons display-->
                                        @if($list->status == 'pending')
                                        @can('isUser')
                                        <form method="GET" action="{{route('ShowEditOrder',['order_id'=>$list->order_id]) }}">
                                            @csrf
                                           
                                            <button class="px-6 py-2 text-black-800 bg-yellow-300">Edit</button>

                                        </form>
                                        <br>
                                        <form method="POST" action="{{route('DeleteOrder',['order_id'=>$list->order_id]) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button class="px-6 py-2 text-black-800 bg-red-300">Delete Order</button>

                                        </form>
                                        
                                        @endcan
                                        @endif
                                    </span>
                                
                                </td>

                                <td class="hidden text-right md:table-cell">


                                </td>
                            </tr>


                            @endforeach

                            @endsection
