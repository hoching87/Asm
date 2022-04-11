@extends('components.header')

@section('content')

<title>Products</title>
<div id='editproducts' data-jwt={{session('jwt')}}></div>
@endsection
<script src='/js/app.js'></script>