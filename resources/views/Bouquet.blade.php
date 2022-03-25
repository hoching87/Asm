
@extends('layouts.frontend')

@section('content')

    <div class="container px-6 mx-auto">
        <h3 class="text-2xl font-medium text-gray-700">Bouquet List</h3>
        <!--Added sort by type selection-->
        <div class="dropdown" aria-labelledby="navbarDropdown">
        <button class="dropbtn" >Sort By Type
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <div class="dropdown-content">

                                     <a class="dropdown-item" href="{{ route('bouquets-type', [ 'type' =>'lilies' ]) }}"> lilies</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', [ 'type' => 'orchids'] ) }}">orchids</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', ['type' => 'roses']) }}">roses</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', ['type' => 'tulip']) }}">tulip</a>
                                    <a class="dropdown-item"href="{{ route('bouquets-type', [ 'type' => 'peony']) }}">peony</a>
                                </div>                                </div>

        <div class="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            

            @foreach ($products as $product)
            
            <div class="w-full max-w-sm mx-auto overflow-hidden rounded-md shadow-md">
                <div class="flex items-end justify-end w-full bg-cover">
                    
                </div>
                <div class="px-5 py-3">
                <h3 class="text-gray-700 uppercase">{{ $product->bouequetName }}</h3>
                    <span class="mt-2 text-gray-500">RM{{ $product->bouequetPrice }}</span>
                    
                    <img src="{{ asset('uploads/images/'.$product->bouquetImage )}}" width="300" height="333" >
                    @can('isAdmin')

                    <!--Method change from POST to GET-->
                    <form method="GET" action="/UpdateBouquet/{{$product['id']}}">
                        @csrf
                       
                            <button type ="submit" class="px-4 py-2 text-white bg-blue-800 rounded">
                                Update Bouquet
                            </button>
                            
                    </form> <br>
                    <form method="POST" action="/Bouquet/{{$product['id']}}">
                        @csrf
                        @method('delete')
                            <button type ="submit" class="px-4 py-2 text-white bg-blue-800 rounded">
                                Delete Bouquet
                            </button>
                            
                    </form>
                    @else
                    <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="id">
                        <input type="hidden" value="{{ $product->bouequetName }}" name="name">
                        <input type="hidden" value="{{ $product->bouequetPrice }}" name="price">
                        <input type="hidden" value="{{ $product->bouquetImage }}"  name="image">
                        <input type="hidden" value="1" name="quantity">
                        <button class="px-4 py-2 text-white bg-blue-800 rounded">Add To Cart</button>
                    </form>
                    @endcan
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
@endsection