@extends('components.header')

@section('content')
<title>Orders</title>
<div id='adminOrders' data-jwt={{session('jwt')}}></div>
@endsection
<script src='/js/app.js'></script>