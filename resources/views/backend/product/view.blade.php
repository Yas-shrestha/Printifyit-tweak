@extends('backend.layouts.main')
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
        <div class="bg-white rounded-3 p-5">
            <h1 class="text-center text-primary ">
                {{ $product->name }}</h1>
            <div class="text-center my-2">
                <img src="{{ asset($product->front_img) }}" alt="under-production">
            </div>
            <div>
                <div class="product-details my-3">
                    <div class="mt-3">
                        <h6>Product Colors</h6>
                        <div class="d-flex gap-2">
                            @php
                                $colors = json_decode($product->color);
                            @endphp
                            @foreach ($colors as $color)
                                <div class="color-swatch"
                                    style="background: {{ $color }}; width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 1px solid #ccc;"
                                    data-color="{{ $color }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6>Product Sizes</h6>
                        <div class="d-flex gap-2">
                            @php
                                $sizes = json_decode($product->size);
                            @endphp
                            @foreach ($sizes as $size)
                                <div class="size-swatch"
                                    style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;"
                                    data-size="{{ $size }}">
                                    {{ $size }}
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>

                <div class="description p-3 my-3 bg-light rounded-3 product-suggestion">
                    <h3 class="my-3 text-center text-primary ">Product Description</h3>
                    {!! $product->description !!}
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
