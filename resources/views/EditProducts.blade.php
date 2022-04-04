@extends('components.header')

@section('content')
<div id='editproducts' data-jwt={{session('jwt')}}></div>
@endsection
<script src='/js/app.js'></script>