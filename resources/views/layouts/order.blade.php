@extends('layouts.frontend')

@section('content')

@foreach ($orderList as $list)
<div>orderID : {{$list->order_id}}</div>
<div>status : {{$list->status}}</div>
<div>date_ordered : {{$list->date_ordered}}</div>
<div>date_delivered : {{$list->date_delivered}}</div>
<a class="dropdown-item" href="{{route('orders',['id'=>$list->order_id]) }}">
    Details
</a>
@endforeach

@endsection