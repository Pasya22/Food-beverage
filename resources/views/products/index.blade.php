@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Product List</h1>
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
                        <a href="#" class="btn btn-primary">Add to Order</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
