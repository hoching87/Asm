@extends('components.header')

@section('content')
<title>Add Orders</title>
<div id='addproducts' data-jwt={{session('jwt')}}></div>
@endsection
<script src='/js/app.js'></script>