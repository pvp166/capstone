@extends('layouts.app')

@section('content')
<div class="container">
    <order-manage :orders="{{json_encode($orders)}}"></order-manage>
    
</div>
@endsection