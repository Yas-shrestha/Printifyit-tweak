@extends('layouts.frontend')

@section('container')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Shopping Cart</h1>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Img</th>
                    <th>Product</th>
                    <th>Price per Item</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="cart-items">
                @foreach ($carts as $cart)
                    <tr class="cart-item" id="cart-{{ $cart->id }}">
                        <td>
                            <a href="{{ $cart->product->img }}">
                                <img src="{{ $cart->product->img }}" alt="" height="50px" width="50px">
                            </a>
                        </td>
                        <td>{{ $cart->product->name }}</td>
                        <td class="product-price">{{ $cart->product->price }}</td>
                        <td>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary minus" onclick="test(this)">-</button>
                                <input type="number" class="form-control quantity" value="{{ $cart->quantity }}"
                                    min="1">
                                <button class="btn btn-outline-secondary plus" onclick="test(this)">+</button>
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control finalPrice outline-0 border-0"
                                value="{{ $cart->quantity * $cart->product->price }}" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeCart{{ $cart->id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="removeCart{{ $cart->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Remove Item</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body">
                                                Are you sure you want to remove this item from the cart?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total:</th>
                    <th class="mainTotal">0</th>
                    <th></th>
                </tr>
            </tfoot>

        </table>
        <div class="d-flex justify-content-between">
            <form action="{{ route('esewa.pay') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">
                    Pay
                </button>

            </form>
        </div>
    </div>


    <script>
        function test(elem) {
            const isMinus = elem.classList.contains('minus');
            const quantityInput = isMinus ?
                elem.nextElementSibling :
                elem.previousElementSibling;
            let quantity = parseInt(quantityInput.value);

            // Adjust quantity for +/- buttons
            quantity = isMinus ? Math.max(1, quantity - 1) : quantity + 1;
            quantityInput.value = quantity;

            const id = elem.closest('tr').getAttribute('id').split('-')[1];

            fetch(`/api/cart/update/${id}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}" // Include CSRF token for security
                    },
                    body: JSON.stringify({
                        quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const pricePerItem = parseInt(elem.closest('tr').querySelector('.product-price').innerText);
                        elem.closest('tr').querySelector('.finalPrice').value = quantity * pricePerItem;
                        calculateTotal();
                    } else {
                        alert('Failed to update quantity');
                    }
                })
                .catch(err => console.error('Error:', err));
        }

        function calculateTotal() {
            const elements = document.querySelectorAll('.finalPrice');
            let total = 0;
            elements.forEach(el => total += parseInt(el.value));
            document.querySelector('.mainTotal').innerText = `$${total}`;
        }

        calculateTotal();
    </script>
@endsection
