@extends('components.header')

@section('content')
<div id='userinfo'  data-jwt={{session("jwt")}}></div>
@endsection



