@extends('layouts.frontend')

@section('content')
<!-- Pages for Order details, same layout as Order page-->
<main class="my-8">
    <div class="container px-6 mx-auto">
        <div class="flex justify-center my-6">
            <div class="flex flex-col w-full p-8 text-gray-800 bg-white shadow-lg pin-r pin-y md:w-4/5 lg:w-4/5">
                @if ($message = Session::get('success'))
                <div class="p-4 mb-3 bg-green-400 rounded">
                    <p class="text-green-800">{{ $message }}</p>
                </div>
                @endif
                <h3 class="text-3xl text-bold">Order Details

                </h3>
                <div class="flex-1">
                    <table class="w-full text-sm lg:text-base" cellspacing="0">
                        <thead>
                            <tr class="h-12 uppercase">
                                <th class="hidden md:table-cell"></th>
                                <th class="text-left">Image</th>
                                
                                <th class="text-left">Quantity</th>
                                <th class="text-left">Price</th>
                             


                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($orderDetail as $detail)
                        <?php
                        $image = substr($detail->image,2,14);
                        ?>
                            <tr>
                                <td class="hidden pb-4 md:table-cell">
                                    <a href="#">

                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                    <img src="{{ asset('uploads/images/'.$image )}}" class="w-20 rounded" alt="Thumbnail">
                                    </a>
                                </td>
                               
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $detail->quantity  }}</p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="mb-2 md:ml-4">{{ $detail->price }}</p>
                                    </a>
                                </td>
                                

                                <td class="hidden text-right md:table-cell">


                                </td>
                            </tr>


                            @endforeach

                        


@endsection