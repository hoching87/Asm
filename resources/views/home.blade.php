@extends('layouts.app')

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
                    <a class="navbar-brand" href="{{ route('AdminViewOrders') }}">
                        View Order
                    </a> <br>


                    @else

                    <a class="navbar-brand" href="{{route('bouquets') }}">
                        View Bouquet
                    </a> <br>
                    <a class="navbar-brand" href="{{ route('cart.list') }}">
                        View Cart
                    </a> <br>
                    <a class="navbar-brand" href="{{ route('UserViewOrders') }}">
                        View Order
                    </a> <br>


                    @endcan

                </div>
            </div>
        </div>
    </div>


</div>
@endsection