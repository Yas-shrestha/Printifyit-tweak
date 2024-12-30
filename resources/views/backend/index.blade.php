@extends('backend.layouts.main')
@section('container')
    <!-- Content wrapper -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <span class="fw-semibold d-block mb-1 text-primary">Product Customized</span>
                        <h3 class="card-title mb-2">{{ Auth::user()->customizedProducts->count() }}</h3>
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
        </div>
        <div class="table">
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
                                {{-- Display product or customProd name --}}
                                <td>
                                    @if ($order->product)
                                        {{ $order->product->name }}
                                    @elseif ($order->customizedProducts)
                                        {{ $order->customizedProducts->products->name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- Display price per item --}}
                                <td>{{ $order->price_per_item }}</td>
                                {{-- Display product or customProd image --}}
                                <td>
                                    @if ($order->product)
                                        <a href="{{ $order->product->front_img }}" target="_blank">
                                            <img src="{{ $order->product->front_img }}" alt="Product Image" height="50px"
                                                width="50px">
                                        </a>
                                    @elseif ($order->customizedProducts)
                                        <a href="{{ $order->customizedProducts->products->front_img }}" target="_blank">
                                            <img src="{{ $order->customizedProducts->products->front_img }}"
                                                alt="Custom Product Image" height="50px" width="50px">
                                        </a>
                                    @else
                                        No Image
                                    @endif
                                </td>
                                {{-- Display product status --}}
                                <td>{{ $order->product_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse

                        <div>{{ $orders->links() }}</div>
                    </tbody>
                </table>
            @else
                <p class="text-center">No orders found.</p>
            @endif

        </div>

        <div class="products ">
            <h1 class="text-primary text-center mt-3"> Your Products</h1>
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
                                    <a href="{{ route('custom.view', $product->id) }}" class="btn btn-primary">View
                                        Customized
                                        Prod</a>
                                    {{-- <form action="{{ route('carts.store') }}" method="POST" enctype="multipart/form-data"
                                        class="pb-2 my-2">
                                        @csrf
                                        <button type="button" class="btn btn-link px-2"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" min="1" max="20"
                                            style="width: 40px" value="1">
                                        <button type="button" class="btn btn-link px-2"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <input type="number" name="customProd_id" value="{{ $product->id }}" readonly
                                            style="display: none;">
                                        <button type="submit" class="btn btn-secondary" title="Add to cart"><i
                                                class="fa-solid fa-cart-shopping"></i></button>
                                    </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{ $products->links() }}
            </div>
        </div>
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
