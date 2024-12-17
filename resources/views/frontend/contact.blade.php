@extends('layouts.frontend')
@section('container')
    <div class="container my-5">
        <div class="row">
            <!-- Contact Details -->
            <div class="col-md-6 mb-4">
                <h3 class="my-3  text-primary">Contact Details</h3>
                <p class="fs-3"><strong>Address:</strong> 123 Amarshing Lane, Web City</p>
                <p class="fs-3"><strong>Email:</strong> contact@example.com</p>
                <p class="fs-3"><strong>Phone:</strong> +1 234 567 890</p>
            </div>

            <!-- Contact Form -->
            <div class="col-md-6">
                <h3>Send Us a Message</h3>
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Enter your email">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" rows="4" name="message" placeholder="Enter your message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
@endsection
