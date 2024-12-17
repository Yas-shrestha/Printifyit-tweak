@extends('layouts.frontend')
@section('container')
    <div class="container">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-2">
                <button class="btn btn-outline-secondary">Products</button>
                <button class="btn btn-outline-secondary">Designs</button>
                <button class="btn btn-outline-secondary">Text</button>
                <button class="btn btn-outline-secondary">Upload</button>
            </div>

            <!-- T-Shirt Preview -->
            <div class="col-md-8 text-center">
                <img id="tshirt-image" src="{{ asset('uploads/non-non-magni-nostru-1731923779.png') }}" class="img-fluid"
                    alt="T-Shirt">
                <div class="btn-group mt-2">
                    <button class="btn btn-light" onclick="changeView('front')">Front</button>
                    <button class="btn btn-light" onclick="changeView('back')">Back</button>
                    <button class="btn btn-light" onclick="changeView('right')">Right</button>
                    <button class="btn btn-light" onclick="changeView('left')">Left</button>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-md-2">
                <h5>Men's Long Sleeve T-Shirt</h5>
                <p>Delivery: Dec 30 - Jan 08</p>
                <h6>Color:</h6>
                <button class="color-option" style="background-color: navy;"></button>
                <button class="color-option" style="background-color: red;"></button>
                <!-- Add other colors -->
                <button class="btn btn-success mt-3">Choose size & quantity</button>
            </div>
        </div>
    </div>
    <script>
        function changeView(view) {
            const image = document.getElementById('tshirt-image');
            switch (view) {
                case 'front':
                    image.src = 'path/to/front-view.png';
                    break;
                case 'back':
                    image.src = 'path/to/back-view.png';
                    break;
                case 'right':
                    image.src = 'path/to/right-view.png';
                    break;
                case 'left':
                    image.src = 'path/to/left-view.png';
                    break;
            }
        }
    </script>
@endsection
