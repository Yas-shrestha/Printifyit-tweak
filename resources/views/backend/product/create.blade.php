@extends('backend.layouts.main')
@section('container')
    <style>
        .selected-items {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            min-height: 40px;
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .selected-item {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-button {
            padding: 10px;
            background-color: #696cff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dropdown-container {
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            border-radius: 5px;
            position: absolute;
            z-index: 10;
            margin-top: 5px;
        }

        .dropdown-container ul {
            list-style: none;
            margin: 0;
            padding: 0
        }

        .dropdown-list li {
            padding: 8px 2rem;
            cursor: pointer;

        }

        .dropdown-list li:hover {
            background-color: #e2e6ea;
        }
    </style>
    <main id="main" class="main">
        @if (Session::has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <section class="content-header">
            <div class="container-fluid p-4">

                <div class="pagetitle">
                    <div class="d-flex justify-content-between">
                        <h1>Create</h1>
                        <a href="{{ route('product.index') }}" class="btn btn-primary btn-md "><i class="fa fa-bars"
                                aria-hidden="true"></i></a>
                    </div>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
                            <li class="breadcrumb-item active">Add-product</li>
                        </ol>
                    </nav>
                    <div class="alert alert-warning text-center" role="alert">
                        Create Your own product :D
                    </div>
                </div><!-- End Page Title -->
                <section class="section">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">name</label>
                                                <input type="text" class="form-control" id="exampleInputText1"
                                                    aria-describedby="textHelp" name="name">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label for="Categories">Categories</label>
                                            <div id="selected-items" class="selected-items">
                                                <!-- Selected items will appear here -->
                                            </div>

                                            <button type="button" id="add-button" class="add-button">Add
                                                Categories</button>

                                            <div id="dropdown-container" class="dropdown-container" style="display: none;">
                                                <ul id="dropdown-list" class="dropdown-list">
                                                    <li data-name="">-select-</li>
                                                    @foreach ($categories as $category)
                                                        <li data-name="{{ $category->name }}">{{ $category->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <input type="hidden" name="selected_categories" id="selected-categories">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">Color</label>
                                                <input type="color" class="form-control" id="exampleInputText1"
                                                    aria-describedby="textHelp" name="color">
                                                @error('color')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">size</label>
                                                <select name="size" id="sizes" class="form-select"
                                                    aria-label="Default select example">
                                                    <option value="" selected>-Select-</option>
                                                    <option value="S">Small</option>
                                                    <option value="M">Medium</option>
                                                    <option value="L">Large</option>
                                                    <option value="XL">Extra Large</option>
                                                    <option value="XXL">XXL</option>
                                                </select>

                                                @error('size')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label for="myEditor">Suggestions</label>
                                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                Please give every detail you want and be as much specific as you can for
                                                precise
                                                design and also mention what product we are working on For ex:- Tshirt,Pant
                                                etc
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            <textarea id="myEditor" name="suggestion"></textarea>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary my-3" name="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>

    </main>
    <script>
        tinymce.init({
            selector: '#myEditor', // Target the specific textarea
            plugins: [
                // Essential plugins
                'image', 'link', 'lists', 'media', 'table', 'wordcount',
                // Optional extras
                'emoticons', 'charmap', 'searchreplace', 'visualblocks'

            ],
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | link image  | numlist bullist  ',
            menubar: false, // Simplify UI by removing menu bar
            branding: false, // Remove "Powered by TinyMCE" branding
            height: 400, // Set a comfortable height for the editor
            image_title: true, // Enable title input for images
            automatic_uploads: false, // Disable TinyMCE's built-in image uploader
            file_picker_types: 'image', // Focus on images for the file picker
            file_picker_callback: function(callback, value, meta) {
                if (meta.filetype === 'image') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function() {
                        const file = this.files[0];
                        const reader = new FileReader();
                        reader.onload = function() {
                            callback(reader.result, {
                                alt: file.name
                            });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }
            },
            content_style: `
                body { font-family:Arial,sans-serif; font-size:14px; }
                img { max-width: 100%; height: auto; }
            ` // Ensure images are responsive
        });
    </script>

    <script>
        function firstFunction() {
            var x = document.querySelector('input[name=img]:checked').value;
            document.getElementById('imagebox').value = x;
        }
        document.getElementById('add-button').addEventListener('click', function() {
            const dropdownContainer = document.getElementById('dropdown-container');
            dropdownContainer.style.display = dropdownContainer.style.display === 'none' ? 'block' : 'none';
        });

        document.querySelectorAll('#dropdown-list li').forEach(function(item) {
            item.addEventListener('click', function() {
                const itemName = item.textContent.trim(); // Get the name of the category

                // Add selected item to display area
                if (itemName) {
                    addItem(itemName);
                }

                // Hide the dropdown after selection
                document.getElementById('dropdown-container').style.display = 'none';
            });
        });

        function addItem(name) {
            const selectedItemsContainer = document.getElementById('selected-items');
            const existingItems = Array.from(selectedItemsContainer.querySelectorAll('.selected-item'));

            // Prevent duplicates by checking if the name already exists
            if (existingItems.some(item => item.textContent === name)) {
                return;
            }

            // Create item element
            const itemElement = document.createElement('span');
            itemElement.classList.add('selected-item');
            itemElement.setAttribute('data-name', name); // Store name as data-name
            itemElement.textContent = name;

            // Add remove functionality on click
            itemElement.addEventListener('click', function() {
                itemElement.remove();
                updateHiddenInput();
            });

            selectedItemsContainer.appendChild(itemElement);
            updateHiddenInput();
        }

        function updateHiddenInput() {
            const selectedNames = Array.from(document.querySelectorAll('.selected-item'))
                .map(item => item.getAttribute('data-name')); // Get names, not IDs
            document.getElementById('selected-categories').value = selectedNames.join(','); // Join names with commas
        }
    </script>
@endsection
