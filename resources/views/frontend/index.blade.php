@extends('layouts.frontend')
@section('container')
    <!-- Call this script after bootstrap.bundle.min.js CDN -->

    </script>
    <section id="banner" style="background: #f9f3ec">
        <div class="csontainer">
            <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                    @forelse ($carousels as $carousel)
                        <div class="swiper-slide py-5">
                            <div class="row banner-content align-items-center">
                                <div class="img-wrapper col-md-5">
                                    <img src="{{ url('uploads/' . $carousel->img) }}" class="img-fluid" />
                                </div>
                                <div class="content-wrapper col-md-7 p-5 mb-5">

                                    <h2 class="banner-title display-1 fw-normal">
                                        {{ $carousel->title }}
                                        <span class="text-primary">{{ $carousel->sub_title }}</span>
                                    </h2>
                                    <a href="/shop" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                                        shop now
                                        <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="swiper-slide py-5">
                            <div class="row banner-content align-items-center">
                                <div class="img-wrapper col-md-5">
                                    <img src="{{ asset('assets/images/model-img.png') }}" class="img-fluid" />
                                </div>
                                <div class="content-wrapper col-md-7 p-5 mb-5">
                                    <div class="secondary-font text-primary text-uppercase mb-4">
                                        Save 10 - 20 % off
                                    </div>
                                    <h2 class="banner-title display-1 fw-normal">
                                        Best destination for
                                        <span class="text-primary">your clothes</span>
                                    </h2>
                                    <a href="/shop" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                                        shop now
                                        <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide py-5">
                            <div class="row banner-content align-items-center">
                                <div class="img-wrapper col-md-5">
                                    <img src="{{ asset('assets/images/model-img.png') }}" class="img-fluid" />
                                </div>
                                <div class="content-wrapper col-md-7 p-5 mb-5">
                                    <div class="secondary-font text-primary text-uppercase mb-4">
                                        Save 10 - 20 % off
                                    </div>
                                    <h2 class="banner-title display-1 fw-normal">
                                        Best destination for
                                        <span class="text-primary">your clothes</span>
                                    </h2>
                                    <a href="/shop" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                                        shop now
                                        <svg width="24" height="24" viewBox="0 0 24 24" class="mb-1">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide py-5">
                            <div class="row banner-content align-items-center">
                                <div class="img-wrapper col-md-5">
                                    <img src="{{ asset('assets/images/model-img.png') }}" class="img-fluid" />
                                </div>
                                <div class="content-wrapper col-md-7 p-5 mb-5">
                                    <div class="secondary-font text-primary text-uppercase mb-4">
                                        Save 10 - 20 % off
                                    </div>
                                    <h2 class="banner-title display-1 fw-normal">
                                        Best destination for
                                        <span class="text-primary">Your Fit </span>
                                    </h2>
                                    <a href="/shop" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                                        shop now

                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="swiper-pagination mb-5"></div>
            </div>
        </div>
    </section>

    {{-- <section id="clothing" class="my-5 overflow-hidden">
        <div class="container pb-5">
            <div class="section-header d-md-flex justify-content-between align-items-center mb-3">
                <h2 class="display-3 fw-normal">Our Products</h2>
                <div>
                    <a href="#" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                        shop now

                    </a>
                </div>
            </div>

            <div class="products-carousel swiper">
                <div class="swiper-wrapper">
                    @foreach ($products as $product)
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
                                                    <input type="number" name="quantity"
                                                        id="quantity_{{ $product->id }}" value="1" min="1"
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
                    @endforeach
                </div>
            </div>
            <!-- / products-carousel -->
        </div>
    </section> --}}

    <section id="service">
        <div class="container py-5 my-5">
            <div class="row g-md-5 pt-4">
                <div class="col-md-3 my-3">
                    <div class="card">
                        <div>
                            <iconify-icon class="service-icon text-primary" icon="la:shopping-cart"></iconify-icon>
                        </div>
                        <h3 class="card-title py-2 m-0">Free Delivery</h3>
                        <div class="card-text">
                            <p class="blog-paragraph fs-6">
                                Lorem ipsum dolor sit amet, consectetur adipi elit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-3">
                    <div class="card">
                        <div>
                            <iconify-icon class="service-icon text-primary" icon="la:user-check"></iconify-icon>
                        </div>
                        <h3 class="card-title py-2 m-0">100% secure payment</h3>
                        <div class="card-text">
                            <p class="blog-paragraph fs-6">
                                Lorem ipsum dolor sit amet, consectetur adipi elit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-3">
                    <div class="card">
                        <div>
                            <iconify-icon class="service-icon text-primary" icon="la:tag"></iconify-icon>
                        </div>
                        <h3 class="card-title py-2 m-0">Daily Offer</h3>
                        <div class="card-text">
                            <p class="blog-paragraph fs-6">
                                Lorem ipsum dolor sit amet, consectetur adipi elit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-3">
                    <div class="card">
                        <div>
                            <iconify-icon class="service-icon text-primary" icon="la:award"></iconify-icon>
                        </div>
                        <h3 class="card-title py-2 m-0">Quality guarantee</h3>
                        <div class="card-text">
                            <p class="blog-paragraph fs-6">
                                Lorem ipsum dolor sit amet, consectetur adipi elit.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="banner-2" class="my-3" style="background: #f9f3ec">
        <div class="container">
            <div class="row flex-row-reverse banner-content align-items-center">
                <div class="img-wrapper col-12 col-md-6">
                    <img src="{{ asset('assets/images/model-img.png') }}" class="img-fluid" alt="">
                </div>
                <div class="content-wrapper col-12 offset-md-1 col-md-5 p-5">
                    <div class="secondary-font text-primary text-uppercase mb-3 fs-4">
                        Let your idea Flow
                    </div>
                    <h2 class="banner-title display-1 fw-normal">Customize your Own !!</h2>
                    <a href="/custom-prod" class="btn btn-outline-dark btn-lg text-uppercase fs-6 rounded-1">
                        shop now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonial">
        <div class="container my-5 py-5">
            <h2 class="display-3 fw-normal text-center">Testimonials</h2>
            <div class="secondary-font text-primary text-center text-uppercase mb-3 fs-4">
                What our customers says
            </div>
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <div class="swiper testimonial-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-2">
                                        <iconify-icon icon="ri:double-quotes-l"
                                            class="quote-icon text-primary"></iconify-icon>
                                    </div>
                                    <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                                        <p class="testimonial-content fs-4">
                                            Best Place to Design Your clothes. The box is simple you just got to throw
                                            everything you want to include and they will print it
                                        </p>
                                        <p class="text-black">- Joshima Lin</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-2">
                                        <iconify-icon icon="ri:double-quotes-l"
                                            class="quote-icon text-primary"></iconify-icon>
                                    </div>
                                    <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                                        <p class="testimonial-content fs-4">
                                            Loved it soo cool Best Place to Design Your clothes. The box is simple you just
                                            got to
                                            throw
                                            everything you want to include and they will print it
                                        </p>
                                        <p class="text-black">- Joshima Lin</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-2">
                                        <iconify-icon icon="ri:double-quotes-l"
                                            class="quote-icon text-primary"></iconify-icon>
                                    </div>
                                    <div class="col-md-10 mt-md-5 p-5 pt-0 pt-md-5">
                                        <p class="testimonial-content fs-4">
                                            Loved the result
                                        </p>
                                        <p class="text-black">- Joshima Lin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
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
