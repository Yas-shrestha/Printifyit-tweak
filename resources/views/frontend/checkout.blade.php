@extends('layouts.frontend')
@section('container')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Checkout</h1>
        <div class="row">
            <!-- Billing Information -->
            <div class="col-md-6">
                <h3>Billing Information</h3>
                <form method="POST" action="process_checkout.php">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                            <option value="" disabled selected>Select a payment method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="cash_on_delivery">Cash on Delivery</option>
                        </select>
                    </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-6">
                <h3>Order Summary</h3>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Product A
                        <span>$50.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Product B
                        <span>$30.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Shipping
                        <span>$5.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <strong>$85.00</strong>
                    </li>
                </ul>
                <button type="submit" class="btn btn-primary w-100">Place Order</button>
            </div>
            </form>
        </div>
    </div>
@endsection
