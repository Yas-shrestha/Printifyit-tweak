@extends('layouts.frontend')

@section('container')
    <!--Banner -->
    {{-- success box --}}
    <div class="container">
        <div class="card bg-primary text-white p-5">
            <div class="card-body">
                <div class="text-center mt-5">
                    <h1 class="card-title text-white fs1 mb-3">Payment Successful</h1>
                    <h3 class="card-subtitle mb-2 text-white ">Thank You for choosing us</h3>
                </div>
                <hr class="my-3">
                <div class="text-center">

                    <h3 class="card-subtitle mb-2 text-white">Payment details</h3>
                </div>
                <div class="details text-center">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Product quantity</th>
                                    <th scope="col">Product Price per unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $data->products->name }}</td>
                                        <td>{{ $data->quantity }}</td>
                                        <td>{{ $data->product->price }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <h3 class="text-white">Amount Payed : {{ $totalAmount }}</h3>

                </div>
            </div>
        </div>
    </div>
    {{-- success box --}}
@endsection
