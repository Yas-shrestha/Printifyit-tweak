@extends('layouts.frontend')

@section('container')
    <!-- Page Header Start -->
    <div class="container">
        <h1 class="display-3 mb-3 animated slideInDown text-white">Cart</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a class="text-body" href="#">Home</a></li>
                <li class="breadcrumb-item text-light active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
    <!-- Page Header End -->

    @if (Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container py-5">
        <section class="cart">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-9 col-md-12">
                    <div class="card card-registration card-registration-2 shadow-lg rounded-3">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-9">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                            <h6 class="mb-0"><a href="#" class="text-body"><i
                                                        class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>
                                        <hr class="my-4">

                                        @foreach ($cart as $item)
                                            <div id="{{ $item->id }}"
                                                class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img src="{{ asset($item->product_id ? $item->products->front_img : $item->customizedProducts->products->front_img) }}"
                                                        class="img-fluid rounded-3 shadow-sm" alt="Product Image">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h5 class="text-muted">
                                                        {{ $item->product_id ? $item->products->name : $item->customizedProducts->products->name }}
                                                    </h5>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                    <button type="button" class="btn btn-link px-2 minus"
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepDown(); test(this);">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="number" name="quantity" id="quantity{{ $item->id }}"
                                                        min="1" max="20" style="width: 45px;"
                                                        class="px-1 quantity-input" value="{{ $item->quantity }}" readonly>
                                                    <button type="button" class="btn btn-link px-2 plus"
                                                        onclick="this.parentNode.querySelector('input[type=number]').stepUp(); test(this);">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2">
                                                    <h6 class="mb-0" id="price">
                                                        Rs{{ $item->product_id ? $item->products->price : $item->customizedProducts->products->price + $item->customizedProducts->customization_charge }}
                                                    </h6>
                                                    <input type="hidden" id="Price" class="price"
                                                        data-price-id="{{ $item->id }}"
                                                        value="{{ $item->product_id ? $item->products->price : $item->customizedProducts->products->price + $item->customizedProducts->customization_charge }}">
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <input type="text" id="finalPrice{{ $item->id }}"
                                                        class="finalPrice text-dark"
                                                        style=" border:none; outline:none; cursor: default;"
                                                        data-price-id="{{ $item->id }}" readonly
                                                        value="Rs{{ $item->product_id ? $item->quantity * $item->products->price : $item->quantity * $item->customizedProducts->products->price + $item->customizedProducts->customization_charge }}">
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <a href="#!" class="text-muted" data-bs-toggle="modal"
                                                        data-bs-target="#modalId{{ $item->id }}">
                                                        <i class="fa-solid fa-trash-can text-danger"></i>
                                                    </a>
                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="modalId{{ $item->id }}" tabindex="-1"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                                        aria-labelledby="modalTitleId" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modalTitleId">Delete?</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this item from the cart?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ route('cart.destroy', $item->id) }}"
                                                                        method="POST">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-danger"><i
                                                                                class="fa-solid fa-trash-can"></i>
                                                                            Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-3 bg-light rounded-3 p-4">
                                    <h3 class="fw-bold mb-5">Summary</h3>
                                    <hr class="my-4">
                                    <div class="d-flex justify-content-between mb-5">
                                        <h5 class="text-uppercase">Total Price</h5>
                                        <h5 class="mainTotal">Rs {{ number_format($totalPrice, 2) }}</h5>
                                    </div>
                                    <form action="{{ route('esewa.pay') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg w-100">Pay Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function test(elem) {
            let quantity;
            if (elem.classList.contains('minus')) {
                quantity = parseInt(elem.nextElementSibling.value);
            } else if (elem.classList.contains('plus')) {
                quantity = parseInt(elem.parentElement.children[1].value);
            }
            const id = elem.parentElement.parentElement.getAttribute('id');
            const pricePerItem = parseInt(elem.parentElement.nextElementSibling.children[1].value);

            fetch(`{{ url('/api/cart/update') }}/${id}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    quantity: quantity
                }),
            }).then(res => {
                if (res.status === 200) {
                    const finalPrice = quantity * pricePerItem;
                    elem.parentElement.nextElementSibling.nextElementSibling.children[0].value =
                        finalPrice; // Numeric only
                    calculateTotal();
                }
            });
        }
    </script>
@endsection
