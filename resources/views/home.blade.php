@extends('components.header')

@section('content')
<title>Home</title>
@can('isAdmin')
<div id='home' data-admin={{true}}></div>
@else
<div id='home' data-admin={{false}}></div>
@endcan
@endsection

<script src='/js/app.js'></script>