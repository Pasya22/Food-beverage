@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Order</h1>
    <form action="{{ route('admin.orders.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="products">Select Products</label>
            @foreach($products as $product)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="products[{{ $product->id }}][id]" value="{{ $product->id }}" id="product-{{ $product->id }}">
                    <label class="form-check-label" for="product-{{ $product->id }}">
                        {{ $product->name }} (${{ $product->price }})
                    </label>
                    <input type="number" class="form-control mt-2" name="products[{{ $product->id }}][quantity]" min="1" value="1" placeholder="Quantity">
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create Order</button>
    </form>
</div>
@endsection
