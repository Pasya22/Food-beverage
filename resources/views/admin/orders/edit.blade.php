@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Order #{{ $order->id }}</h1>
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="products">Select Products</label>
            @foreach($products as $product)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}"
                        id="product-{{ $product->id }}"
                        {{ $order->products->contains($product) ? 'checked' : '' }}>
                    <label class="form-check-label" for="product-{{ $product->id }}">
                        {{ $product->name }} (${{ $product->price }})
                    </label>
                    <input type="number" class="form-control mt-2" name="products[{{ $loop->index }}][quantity]" min="1"
                        value="{{ $order->products->contains($product) ? $order->products->find($product->id)->pivot->quantity : 1 }}"
                        placeholder="Quantity">
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Order</button>
    </form>
</div>
@endsection
