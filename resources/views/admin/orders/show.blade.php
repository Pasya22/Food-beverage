@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Details</h1>
    <p><strong>User:</strong> {{ $order->user->name }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
    <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>

    <h3>Products</h3>
    <ul>
        @foreach($order->products as $product)
            <li>
                {{ $product['name'] }} - Quantity: {{ $product['quantity'] }} - Price: ${{ $product['price'] }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Back to Orders</a>
</div>
@endsection
