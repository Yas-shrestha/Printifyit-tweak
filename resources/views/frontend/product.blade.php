@extends('layouts.frontend')
@section('container')
    <div class="container">
        <h1>Products</h1>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card">
                    <a href="">
                        <img src="https://images.unsplash.com/photo-1561154464-82e9adf32764?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=800&q=60"
                            class="card-img-top" alt="..." style="height: 300px;object-fit:cover">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">Hoodie</h5>
                        <h6 class="card-subtitle mb-2 text-muted ">Customize hoodie</h6>
                        <p class="card-text">Customize hoodie</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
