@extends('layouts.frontend')

@section('content')

@foreach ($order as $order)
<div>orderID : {{$order->order_id}}</div>
<div>status : {{$order->status}}</div>
<div>date_ordered : {{$order->date_ordered}}</div>
<div>date_delivered : {{$order->date_delivered}}</div>
@endforeach

@foreach ($orderDetail as $detail)
===========
<div>details_id : {{$detail->details_id}}</div>
<div>item_id : {{$detail->item_id}}</div>
<div>quantity : {{$detail->quantity}}</div>
<div>price : {{$detail->price}}</div>
@endforeach

@endsection