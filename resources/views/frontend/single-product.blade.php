@extends('layouts.frontend')
@section('container')
    <style>
        img {
            height: 300px;
            width: 300px;
            object-fit: contain;
            object-position: top;
        }

        .product-suggestion img {
            height: 50px;
            width: 50px;
        }
    </style>
    <div class="container my-5">
        <h1>Product Information</h1>
        <div class="bg-white rounded-3 p-5">
            <h1 class="text-center text-primary ">
                {{ $product->name }}</h1>
            <div class="text-center my-2">
                <img src="{{ asset($product->img) }}" alt="under-production">
            </div>
            <div>
                <strong class="my-3"><span class="text-primary">Size :</span> {{ $product->size }}</strong> <br>
                <strong class="my-3"><span class="text-primary">Category :</span> {{ $product->category }}</strong>
                <div class="alert mt-3 alert-warning alert-dismissible fade show" role="alert">
                    You can click on img to see it on new tab
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="description p-3 my-3 bg-light rounded-3 product-suggestion">
                    <h3 class="my-3 text-center text-primary ">Product Description</h3>
                    {!! $product->suggestion !!}
                </div>
                <div class="user-info text-center">
                    Created by <span class="text-primary">{{ $product->user->name }}</span>
                </div>

            </div>
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
