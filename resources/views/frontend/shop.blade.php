@extends('layouts.frontend')
@section('container')
    <section id="banner-2" class="my-3" style="background: #f9f3ec">
        <div class="container p-5 text-center">
            <h1>Customize your Own Product </h1>

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
                                <a href="{{ asset($product->front_img) }}" target="_blank">
                                    <img src="{{ asset($product->front_img) }}" class="img-fluid rounded-4"
                                        alt="image" /></a>
                                <div class="card-body p-0">
                                    <h3 class="card-title pt-4 m-0">{{ $product->name }}</h3>
                                    <div class="card-text">

                                        <h3 class="secondary-font text-primary">{{ $product->price }}</h3>

                                        <a href="{{ route('customize.prod', $product->id) }}"
                                            class="btn btn-light me-3  px-4 pt-3 pb-3 border-0 rounded-3">
                                            Customize</a>
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
