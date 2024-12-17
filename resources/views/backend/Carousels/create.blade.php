@extends('backend.layouts.main')
@section('container')
    <main id="main" class="main">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid p-4">

                    <div class="pagetitle">
                        <div class="d-flex justify-content-between">
                            <h1>Add</h1>
                        </div>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">carousels</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                    <section class="section">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('carousels.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row t">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="exampleInputText1" class="form-label">Title</label>
                                                    <input type="text" class="form-control" id="exampleInputText1"
                                                        aria-describedby="textHelp" name="title">

                                                </div>




                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="mb-3">
                                                        <!-- Modal trigger button -->
                                                        <!-- Modal Body -->
                                                        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                                        <div class="modal fade" id="modalId" tabindex="-1"
                                                            data-bs-backdrop="static" data-bs-keyboard="false"
                                                            role="dialog" aria-labelledby="modalTitleId"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="modalTitleId">Choose
                                                                            photo
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">


                                                                        <style>
                                                                            [type=radio]:checked+img {
                                                                                outline: 2px solid #f00;
                                                                            }
                                                                        </style>

                                                                        @foreach ($files as $file)
                                                                            <label>
                                                                                <input type="radio" name="img"
                                                                                    value="{{ $file->img }}"
                                                                                    style="opacity: 0;" />
                                                                                <img src="{{ asset('uploads/' . $file->img) }}"
                                                                                    alt="" height="100px;"
                                                                                    width="100px;"
                                                                                    style="margin-right:20px; margin-bottom:10px;">
                                                                            </label>
                                                                        @endforeach
                                                                        <div>
                                                                            {{ $files->links() }}
                                                                        </div>
                                                                        <?php
                                                                        ?>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            data-bs-dismiss="modal"
                                                                            onclick=" firstFunction()">Save</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Optional: Place to the bottom of scripts -->
                                                        <script>
                                                            const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
                                                        </script>
                                                    </div>
                                                    <div class="form-group col-12 mb-0">
                                                        <label class="col-form-label">Image</label>
                                                    </div>
                                                    <div class="input-group mb-3 col">
                                                        <input id="imagebox" type="text" class="form-control" disabled
                                                            name="img" readonly>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary btn-md"
                                                                data-bs-toggle="modal" data-bs-target="#modalId">
                                                                Choose Image
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="exampleInputText1" class="form-label">Sub_title</label>
                                                    <input type="text" class="form-control" id="exampleInputText1"
                                                        aria-describedby="textHelp" name="sub_title">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="">

                                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                        </div>
                                    </form>
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
