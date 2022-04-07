@extends('components.header')

@section('content')
<title>Personal Information</title>
<div id='userinfo'  data-jwt={{session("jwt")}}></div>
@endsection



