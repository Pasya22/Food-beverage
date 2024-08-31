@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Product</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('path/to/image.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
                            <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
                            <div class="form-group">
                                <label for="quantity-{{ $product->id }}">Quantity</label>
                                <input type="number" class="form-control" name="products[{{ $product->id }}][quantity]" id="quantity-{{ $product->id }}" min="1" max="{{ $product->stock }}">
                                <input type="hidden" name="products[{{ $product->id }}][id]" value="{{ $product->id }}">
                                <input type="hidden" name="products[{{ $product->id }}][price]" value="{{ $product->price }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Place Order</button>
        </div>
    </form>
</div>
@endsection
