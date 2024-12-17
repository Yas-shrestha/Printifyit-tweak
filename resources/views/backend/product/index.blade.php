@extends('backend.layouts.main')
@section('container')
    <main id="main" class="main">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid p-4">
                    <div class="pagetitle">
                        @if (Session::has('msg'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session('msg') }}
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
                        <div class="d-flex justify-content-between">
                            <h1>Manage product</h1>
                            <a href="{{ route('product.create') }}" class="btn btn-primary btn-md p-3"><i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                                <li class="breadcrumb-item active">Manage-product</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                    <section class="section">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <table
                                        class="table table-striped overflow-hidden table-hover table-bordered table-lg table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th scope="col">S.N</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Img</th>
                                                <th scope="col">Request Status</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Price Per Item</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        @if ($product->img != '')
                                                            <a href="{{ asset($product->img) }}" target="_blank"
                                                                alt ="not set"><img src="{{ asset($product->img) }}"
                                                                    alt="" height="50px" width="50px"></a>
                                                        @elseif ($product->req_status != 'accepted')
                                                            <p>Not accepted</p>
                                                        @else
                                                            <p>under-production</p>
                                                        @endif
                                                    </td>

                                                    @if (Auth::user() && Auth::user()->role == 'user')
                                                        <td>
                                                            <span
                                                                class="badge rounded-pill 
                                                            {{ $product->req_status == 'pending' ? 'bg-warning' : '' }}
                                                            {{ $product->req_status == 'rejected' ? 'bg-danger' : '' }}
                                                            {{ $product->req_status == 'accepted' ? 'bg-success' : '' }}">
                                                                {{ $product->req_status }}
                                                            </span>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <form action="{{ route('update.reqStatus', $product->id) }}"
                                                                method="POST">

                                                                @csrf

                                                                <select class="form-select" name="req_status"
                                                                    aria-label="Product Status">
                                                                    <option selected disabled>Select status</option>
                                                                    <option value="pending"
                                                                        {{ $product->req_status == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="rejected"
                                                                        {{ $product->req_status == 'rejected' ? 'selected' : '' }}>
                                                                        Rejected</option>
                                                                    <option value="accepted"
                                                                        {{ $product->req_status == 'accepted' ? 'selected' : '' }}>
                                                                        Accept</option>
                                                                </select>
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-primary my-1">Change</button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                    @if ($product->req_status == 'accepted')
                                                        @if (Auth::user() && Auth::user()->role == 'user')
                                                            <td>
                                                                <span
                                                                    class="badge rounded-pill 
                                                        {{ $product->product_status == 'pending' ? 'bg-warning' : '' }}
                                                        {{ $product->product_status == 'processing' ? 'bg-primary' : '' }}
                                                        {{ $product->product_status == 'finish' ? 'bg-success' : '' }}">
                                                                    {{ $product->product_status }}
                                                                </span>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <form action="{{ route('update.status', $product->id) }}"
                                                                    method="POST">

                                                                    @csrf
                                                                    <select class="form-select" name="product_status"
                                                                        aria-label="Product Status">
                                                                        <option selected disabled>Select status</option>
                                                                        <option value="pending"
                                                                            {{ $product->product_status == 'pending' ? 'selected' : '' }}>
                                                                            Pending</option>
                                                                        <option value="processing"
                                                                            {{ $product->product_status == 'processing' ? 'selected' : '' }}>
                                                                            Processing</option>
                                                                        <option value="finished"
                                                                            {{ $product->product_status == 'finished' ? 'selected' : '' }}>
                                                                            Finished</option>
                                                                    </select>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary my-1">Change</button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                        <td id="price">
                                                            Rs {{ $product->price }}

                                                            <!-- Button trigger modal -->
                                                            @if (Auth()->user() && Auth()->user()->role != 'user')
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editPrice{{ $product->id }}">
                                                                    {{ $product->price ? 'Edit' : 'Add' }} Price
                                                                </button>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="editPrice{{ $product->id }}"
                                                                    tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                    aria-hidden="true">
                                                                    <div
                                                                        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">
                                                                                    Edit
                                                                                    Price</h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <form
                                                                                action="{{ route('update.price', $product->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <div class="modal-body">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <label
                                                                                            for="addPrice{{ $product->id }}"
                                                                                            class="me-2">Price</label>
                                                                                        <input type="number" name="price"
                                                                                            id="addPrice{{ $product->id }}"
                                                                                            min="1"
                                                                                            class="form-control flex-grow-1"
                                                                                            value="{{ $product->price }}"
                                                                                            required>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-bs-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td></td>
                                                        <td></td>
                                                    @endif

                                                    {{-- <td>{{ $product->category->name }}</td> --}}
                                                    <td>
                                                        <a href="{{ route('product.edit', $product->id) }}"
                                                            class="btn btn-md btn-primary"><i class="fa fa-pencil"
                                                                aria-hidden="true"></i></a>
                                                        <a href="{{ route('product.show', $product->id) }}"
                                                            class="btn btn-md btn-secondary"><i class="fa fa-eye"
                                                                aria-hidden="true"></i></a>
                                                        <!-- Modal trigger button -->
                                                        @if ($product->user->id == Auth::id() || Auth::user()->role == 'admin')
                                                            <button type="button" class="btn btn-danger btn-md"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalId{{ $product->id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </button>

                                                            <!-- Modal Body -->
                                                            <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                                            <div class="modal fade" id="modalId{{ $product->id }}"
                                                                tabindex="-1" data-bs-backdrop="static"
                                                                data-bs-keyboard="false" role="dialog"
                                                                aria-labelledby="modalTitleId" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modalTitleId">
                                                                                Delete
                                                                                ??
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Are you sure
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form
                                                                                action="{{ route('product.destroy', $product->id) }}"
                                                                                method="POST"
                                                                                enctype="multipart/form-data">
                                                                                @method('delete')
                                                                                @csrf
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" name="submit"
                                                                                    class="btn btn-danger"><i
                                                                                        class="fa-solid fa-trash-can"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!-- Optional: Place to the bottom of scripts -->
                                                            <script>
                                                                const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                                            </script>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div>
                                        {{ $products->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </main>
    <script>
        function firstFunction() {
            var x = document.querySelector('input[name=img]:checked').value;
            document.getElementById('imagebox').value = x;
        }
    </script>
@endsection
