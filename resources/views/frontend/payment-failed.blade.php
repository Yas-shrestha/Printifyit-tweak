@extends('layouts.frontend')

@section('container')
    <!--Banner -->

    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Products</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Payment Success</li>
            </ol>
        </nav>
    </div>
    </div>
    </div>
    {{-- success box --}}
    <div class="container">
        <div class="card bg-danger text-white p-5">
            <div class="card-body">
                <div class="text-center mt-5">
                    <h1 class="card-title text-white fs1 mb-3">Payment Failed</h1>
                    <h3 class="card-subtitle mb-2 text-white ">We are sorry</h3>
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
                                    <th scope="col">Product Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>
                                            @if ($data->customProd_id)
                                                {{ $data->customizedProducts->name }} (Customized)
                                            @else
                                                {{ $data->product->name }}
                                            @endif
                                        </td>
                                        <td>{{ $data->quantity }}</td>
                                        <td>
                                            @if ($data->customProd_id)
                                                {{ $data->customizedProducts->price + $data->customizedProducts->customization_charge }}
                                            @else
                                                {{ $data->product->price }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- success box --}}
@endsection
