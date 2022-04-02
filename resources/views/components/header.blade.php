@php
$jwt = null;
$user = null;
@endphp

@auth
@php
$jwt = session('jwt');
$user = Auth::user()->name;
@endphp
@endauth

<div id='header' data-jwt={{$jwt}} data-user={{$user}} data-url={{url()->current()}}></div>

<div>@yield('content')</div>

<script src='/js/app.js'></script>