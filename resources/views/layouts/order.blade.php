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
                                    <a href="#">
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
                                <td class="hidden text-right md:table-cell">
                                    <span class="text-sm font-medium lg:text-base">
                                        <a class="dropdown-item" href="{{route('orders',['id'=>$list->order_id]) }}">
                                            View
                                        </a>
                                    </span>
                                    @can('isAdmin')
                                    <form method="POST" action="{{route('AcceptOrder',['order_id'=>$list->order_id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <span class="text-sm font-medium lg:text-base">
                                    <input type="submit" class="spring-btn btn-lg btn-block" value="Accept" />

                                    </span>
                                    </form>
                                    @endcan
                                </td>

                                <td class="hidden text-right md:table-cell">


                                </td>
                            </tr>


                            @endforeach

                            @endsection