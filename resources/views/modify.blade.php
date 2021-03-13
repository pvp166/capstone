@extends('layouts.app')

@section('content')
<div class="container">
    <pizza-modify :id="{{ json_encode($id) }}" :item="{{ json_encode($item) }}" :itemprice="{{ json_encode($itemPrice) }}" :topping="{{ json_encode($topping) }}"></pizza-modify>
    
</div>
@endsection
