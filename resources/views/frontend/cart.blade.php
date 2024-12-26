@extends('layouts.frontend')

@section('container')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Customize-Product</h1>
        <h3 class="text-center mb-4">The Additional customization price is included here wire</h3>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Img</th>
                    <th>Product</th>
                    <th>Price </th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="cart-items">
                @foreach ($carts as $cart)
                    @php
                        // Decode the JSON in the views field to access the front image
                        $views = json_decode($cart->views, true);
                        $frontImage = $views['front']['image'] ?? null; // Get the front view image, if available
                    @endphp
                    <tr class="cart-item" id="cart-{{ $cart->id }}">
                        <td>
                            @if ($frontImage)
                                <img src="{{ $frontImage }}" alt="Front View" height="50px" width="50px">
                            @else
                                <img src="{{ $cart->products->front_img }}" alt="Front View" height="50px" width="50px">
                            @endif
                        </td>
                        <td>{{ $cart->products->name }}</td>
                        <td class="product-price">{{ $cart->products->price + $cart->customization_charge }}</td>

                        <td>
                            <a href="{{ route('custom.view', $cart->id) }}" class="btn btn-secondary"><i class="fa fa-eye"
                                    aria-hidden="true"></i></a>
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
                    <th colspan="3" class="text-end">Total:</th>
                    <th class="mainTotal">0</th>
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
