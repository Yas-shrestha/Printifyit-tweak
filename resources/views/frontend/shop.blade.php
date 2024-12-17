@extends('layouts.frontend')
@section('container')
    <section id="banner-2" class="my-3" style="background: #f9f3ec">
        <div class="container p-5 text-center">
            <h1>Customize your Own Product .<span class="text-primary"> How???</span> </h1>
            <span class="fs-2">Click This Button </span><a href="{{ route('product.create') }}" style="padding: 4px 1rem"
                class="btn btn-primary btn-sm fs-3">
                Click Me 👈</a>
        </div>
    </section>
    <section id="clothing" class="my-5 overflow-hidden">
        <div class="container pb-5">
            <div class="section-header text-center mb-4">
                <h2 class="display-3 fw-normal">Products</h2>
                <div class="secondary-font text-primary text-uppercase mb-3 fs-4">
                    View our products
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 com-12 mb-3">
                        <div class="swiper-slide">

                            <div class="card position-relative">
                                <a href="{{ route('prod.detail', $product->id) }}" target="_blank"><img
                                        src="{{ asset($product->img) }}" class="img-fluid rounded-4" alt="image" /></a>
                                <div class="card-body p-0">
                                    <a href="{{ route('prod.detail', $product->id) }}" target="_blank">
                                        <h3 class="card-title pt-4 m-0">{{ $product->name }}</h3>
                                    </a>
                                    <div class="card-text">

                                        <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                        <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                        <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                        <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                        <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                                        5.0</span>

                                        <h3 class="secondary-font text-primary">{{ $product->price }}</h3>

                                        <div class=" mt-3">

                                            <form action="{{ route('carts.store', $product->id) }}" method="POST">
                                                @csrf
                                                <div class="my-2"
                                                    style="display: flex; align-items: center;justify-content:center">
                                                    <button type="button"
                                                        onclick="decrement({{ $product->id }})">-</button>
                                                    <input type="number" name="quantity" id="quantity_{{ $product->id }}"
                                                        value="1" min="1"
                                                        style="width: 50%; text-align: center;">
                                                    <button type="button"
                                                        onclick="increment({{ $product->id }})">+</button>
                                                </div>
                                                <button type="submit"
                                                    class="btn-cart me-3 px-4 pt-3 pb-3 border-0 rounded-3">
                                                    Add to cart
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- / products-carousel -->
        </div>
    </section>
    <script>
        function increment(index) {
            let input = document.getElementById("quantity_" + index);
            input.value = parseInt(input.value) + 1;
        }

        function decrement(index) {
            let input = document.getElementById("quantity_" + index);
            if (input.value > input.min) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection
