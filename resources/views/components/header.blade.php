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

@can('isAdmin')
<div id='header' data-jwt={{$jwt}} data-user={{$user}} data-admin={{true}}></div>
@else
<div id='header' data-jwt={{$jwt}} data-user={{$user}}></div>
@endcan

<div>@yield('content')</div>

<script src='/js/app.js'></script>