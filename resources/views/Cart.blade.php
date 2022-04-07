@extends('components.header')

@section('content')
<title>User Cart </title>
<div id='cart' data-jwt={{session('jwt')}}></div>
@endsection
<script src='/js/app.js'></script>