@extends('layouts.frontend')
@section('container')
    <div class="container my-5">
        <h1>Your customized Products</h1>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card shadow">
                        <img src="{{ asset($product->products->front_img) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->products->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted ">Customization-Charge : Rs
                                {{ $product->customization_charge }}</h6>
                            <div class="d-flex gap-2 W-100">
                                @if ($product->color || $product->size)
                                    @if ($product->color)
                                        <div
                                            style="display: inline-block; padding: 10px; background-color: {{ $product->color }}; color: #fff; border-radius: 4px;">
                                            Color: {{ ucfirst($product->color) }}
                                        </div>
                                    @endif
                                    @if ($product->size)
                                        <div
                                            style="display: inline-block; padding: 10px; background-color: #007bff; color: #fff; border-radius: 4px;">
                                            Size: {{ ucfirst($product->size) }}
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <div class="my-2">
                                <a href="{{ route('custom.view', $product->id) }}" class="btn btn-primary">View Customized
                                    Prod</a>
                                <form action="{{ route('carts.store') }}" method="POST" enctype="multipart/form-data"
                                    class="pb-2 my-2">
                                    @csrf
                                    <button type="button" class="btn btn-link px-2"
                                        onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" min="1" max="20" style="width: 40px"
                                        value="1">
                                    <button type="button" class="btn btn-link px-2"
                                        onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <input type="number" name="customProd_id" value="{{ $product->id }}" readonly
                                        style="display: none;">
                                    <button type="submit" class="btn btn-secondary" title="Add to cart"><i
                                            class="fa-solid fa-cart-shopping"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select all the images inside the suggestion content
            const images = document.querySelectorAll('.product-suggestion img');

            // Loop through each image and wrap it in a link
            images.forEach(function(image) {
                const imgSrc = image.getAttribute('src'); // Get the image source
                const link = document.createElement('a'); // Create a new anchor tag
                link.setAttribute('href', imgSrc); // Set the href to the image source
                link.setAttribute('target', '_blank'); // Open in a new tab

                // Wrap the image with the anchor tag
                image.parentNode.insertBefore(link, image);
                link.appendChild(image); // Append the image inside the link
            });
        });
    </script>
@endsection
