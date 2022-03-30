@extends('layouts.frontend')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('FlowerShop') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                   
                    <br>
                    @can('isAdmin')
                    <a class="navbar-brand" href="{{ url('/AddBouquet') }}">
                    Add Bouquet
                    </a> <br>
                    <a class="navbar-brand" href="{{ route('bouquets') }}">
                    View Bouquet
                    </a> <br>
                    <a class="navbar-brand" href="{{ url('/Order') }}">
                    View Order
                    </a> <br>
                   

                    @else
                    
                    <a class="navbar-brand" href="{{route('bouquets') }}">
                    View Bouquet
                    </a> <br>
                    <a class="navbar-brand" href="{{ url('/Bouquet') }}">
                    View Cart
                    </a> <br>
                    <a class="navbar-brand" href="{{ url('/Bouquet') }}">
                    View Order
                    </a> <br>
                    
                    
                    @endcan
                    
                </div>
            </div>
        </div>
    </div>
</div>


<div class="bg-image background-" style="background-image: url('https://cdn.pixabay.com/photo/2016/11/21/16/02/basket-1846135_960_720.jpg'); height: 600px;">
</div>


<p class="py-5 text-center">This example creates a full page background image. Try to resize the browser window to see how it always will cover the full screen (when scrolled to top), and that it scales nicely on all screen sizes.</p>
<br>
<hr class="border-top: 1px solid #8c8b8b">


<div class="container px-6 mx-6 my-6 px-6 py-6">
        <h3 class="text-2xl font-medium text-gray-700">Our Product</h3>
        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            

            @foreach ($products as $product)
            
            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                <a href="/Bouquet"><div class="flex items-end justify-end w-full bg-cover">
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase">{{ $product->bouequetName }}</h3>
                        <span class="mt-2 text-gray-500">RM{{ $product->bouequetPrice }}</span>
                        <img src="{{ asset('uploads/images/'.$product->bouquetImage )}}" width="300" height="333" >
                    </div>
                </div></a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="text-center button-container mt-6">
        <a href="/Bouquet" class="px-4 py-2 text-white bg-blue-800 rounded">View more products</a>
    </div>
</div>

<div class="mx-6 my-6 px-6 py-6">
    <br>
    <hr class="border-top: 1px solid #8c8b8b">
    <p class="text-center text-2xl font-medium my-4"> Blog </p>
</div>

<div class="container px-6 mx-6 my-4 px-6 py-4">
        <div class="grid grid-cols-1 gap-9 mt-6 sm:grid-cols-2 lg:grid-cols-3 ">

            @foreach ($blogs as $blog)
            
            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                <a href="/Blog"><div class="flex items-end justify-end w-full bg-cover">
                    <div class="px-5 py-3">
                        <h3 class="text-gray-700 uppercase font-medium">{{ $blog->blogTitle }}</h3>
                        <p class="text-center my-2 text-gray-500">By {{ $blog->author }}</p>
                        <img src="{{ asset('uploads/images/'.$blog->pictures )}}" width="350" height="333" >
                    </div>
                </div></a>
            </div>
            @endforeach
        </div>
</div>
<div class="text-center button-container mt-6">
    <a href="/Bouquet" class="px-4 py-2 text-white bg-blue-800 rounded">Read more</a>
</div>

<x-footer />

@endsection

