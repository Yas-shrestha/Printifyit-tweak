@extends('backend.layouts.main')
@section('container')
    <!-- Content wrapper -->
{{-- 
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1 text-primary">Product Created</span>
                        <h3 class="card-title mb-2">{{ Auth::user()->product->count() }}</h3>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1 text-primary">Product Ordered</span>
                        <h3 class="card-title mb-2">{{ Auth::user()->order->count() }}</h3>
                    </div>

                </div>
            </div>
        </div> --}}
        {{-- <div class="table">
            <h1 class="text-primary text-center mt-4">Your Orders</h1>
            @if (Auth::check() && Auth::user()->order)
                <table class="table table-light table-striped table-hover table-bordered table-sm table-responsive-sm">
                    <thead>
                        <tr>
                            <th scope="col">S.N</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Img</th>
                            <th scope="col">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $order->product->name }}</td>
                                <td>{{ $order->price_per_item }}</td>
                                <td><a href="{{ $order->product->img }}" target="_blank"><img
                                            src="{{ $order->product->img }}" alt="" height="50px"
                                            width="50px"></a></td>
                                <td>{{ $order->product_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                        <div>{{ $orders->links() }}</div>
                    </tbody>
                </table>
            @else
                <p class="text-center">No orders found.</p>
            @endif

        </div> --}}

        {{-- <div class="products ">
            <h1 class="text-primary text-center mt-3"> Your Products</h1>
            <div class="row">
                @php
                    $products = Auth::user()->product()->paginate(8);
                @endphp
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <a href="{{ route('product.show', $product->id) }}"> <img src="{{ $product->img }}"
                                    class="card-img-top" alt="..." height="250px" style="object-fit: cover"></a>
                            <div class="card-body">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h4 class="card-title text-primary">{{ $product->name }}</h4>
                                </a>
                                <h6 class="card-subtitle mb-2 text-muted ">{{ $product->price }}</h6>

                                <form action="{{ route('carts.store', $product->id) }}" class="text-center" method="POST">
                                    @csrf
                                    <div class="my-2" style="display: flex; align-items: center;justify-content:center">
                                        <button type="button" onclick="decrement({{ $product->id }})">-</button>
                                        <input type="number" name="quantity" id="quantity_{{ $product->id }}"
                                            value="1" min="1" style="width: 50%; text-align: center;">
                                        <button type="button" onclick="increment({{ $product->id }})">+</button>
                                    </div>
                                    <button type="submit"
                                        class="btn-cart me-3 px-4 pt-3 pb-3 border-0 rounded-3 text-center">
                                        Add to cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty
                    <p class="text-center">No orders found.</p>
                @endforelse
                @php
                    $products = Auth::user()->product()->paginate(10); // Paginate 10 products per page
                @endphp
            </div>
        </div> --}}
    </div>

    <!-- / Content -->
    {{-- <script>
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
    </script> --}}
@endsection
