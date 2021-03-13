@extends('layouts.app')

@section('content')
<div class="container">
    
<checkoutpage :orders="{{json_encode($orders)}}" :address="{{json_encode($address)}}" :user="{{json_encode($user)}}" :topping="{{json_encode($order_topping)}}" ></checkoutpage>

</div>

@endsection
