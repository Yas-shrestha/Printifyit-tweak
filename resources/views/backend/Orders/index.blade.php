@extends('backend.layouts.main')
@section('container')
    <main id="main" class="main">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid p-4">
                    <div class="pagetitle">
                        @if (Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">add-order</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                    <section class="section">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <table
                                        class="table table-striped table-hover table-bordered table-lg table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th scope="col">S.N</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Payment</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>

                                                    {{-- Handle product or customizedProducts --}}
                                                    <td>
                                                        @if (isset($order->product))
                                                            {{ $order->product->name }}
                                                        @elseif (isset($order->customizedProducts))
                                                            {{ $order->customizedProducts->name }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if (isset($order->product->front_img))
                                                            <a target="_blank" href="{{ url($order->product->front_img) }}">
                                                                <img src="{{ asset($order->product->front_img) }}"
                                                                    width="50px" height="50px" alt="no">
                                                            </a>
                                                        @elseif (isset($order->customizedProducts->products->front_img))
                                                            <a target="_blank"
                                                                href="{{ url($order->customizedProducts->products->front_img) }}">
                                                                <img src="{{ asset($order->customizedProducts->products->front_img) }}"
                                                                    width="50px" height="50px" alt="no">
                                                            </a>
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>

                                                    @if (Auth::user() && Auth::user()->role == 'user')
                                                        <td>
                                                            <span
                                                                class="badge rounded-pill 
                                                            {{ $order->product_status == 'ordered' ? 'bg-warning' : '' }}
                                                            {{ $order->product_status == 'On_Production' ? 'bg-primary' : '' }}
                                                            {{ $order->product_status == 'Finished' ? 'bg-success' : '' }}
                                                            {{ $order->product_status == 'Delivering' ? 'bg-primary' : '' }}
                                                            {{ $order->product_status == 'Delivered' ? 'bg-success' : '' }}">
                                                                {{ $order->product_status }}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <form action="{{ route('orders.update', $order->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <select class="form-select" name="product_status"
                                                                    aria-label="Product Status">
                                                                    <option selected disabled>Select status</option>
                                                                    <option value="ordered"
                                                                        {{ $order->product_status == 'ordered' ? 'selected' : '' }}>
                                                                        Ordered</option>
                                                                    <option value="On_Production"
                                                                        {{ $order->product_status == 'On_Production' ? 'selected' : '' }}>
                                                                        Processing</option>
                                                                    <option value="Finished"
                                                                        {{ $order->product_status == 'Finished' ? 'selected' : '' }}>
                                                                        Finished</option>
                                                                    <option value="Delivering"
                                                                        {{ $order->product_status == 'Delivering' ? 'selected' : '' }}>
                                                                        Delivering</option>
                                                                    <option value="Delivered"
                                                                        {{ $order->product_status == 'Delivered' ? 'selected' : '' }}>
                                                                        Delivered</option>
                                                                </select>
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-primary my-1">Change</button>
                                                            </form>
                                                        </td>
                                                    @endif

                                                    <td>{{ $order->price_per_item }}</td>

                                                    <td>
                                                        <span
                                                            class="badge rounded-pill 
                                                        {{ $order->esewa_status == 'Paid' ? 'bg-success' : '' }}
                                                        {{ $order->esewa_status == 'Canceled' ? 'bg-danger' : '' }}">
                                                            {{ $order->esewa_status }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <a href="{{ route('orders.show', $order->id) }}"
                                                            class="btn btn-md btn-secondary">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $orders->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </main>
@endsection
