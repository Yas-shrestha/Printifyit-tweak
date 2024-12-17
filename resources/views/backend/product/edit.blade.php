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

        .prd-suggest img {
            height: 50px;
            width: 50px;
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
                            <li class="breadcrumb-item active">Edit-product</li>

                        </ol>
                    </nav>
                </div><!-- End Page Title -->
                <section class="section">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('product.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">name</label>
                                                <input type="text" class="form-control" id="exampleInputText1"
                                                    value="{{ $product->name }}" value="{{ $product->name }}"
                                                    aria-describedby="textHelp" name="name">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">Color</label>
                                                <input type="color" class="form-control" id="exampleInputText1"
                                                    aria-describedby="textHelp" name="color"
                                                    value="{{ $product->color }}">
                                                @error('color')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <label for="Categories">Categories</label>
                                            <div id="selected-items" class="selected-items">
                                                <!-- Pre-fill selected categories -->
                                                @foreach (explode(',', $product->category) as $category)
                                                    <span class="selected-item" data-name="{{ $category }}">
                                                        {{ $category }}
                                                        <span class="remove-item"> ×</span>
                                                        <!-- Remove button for backend categories -->
                                                    </span>
                                                @endforeach
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

                                            <input type="hidden" name="selected_categories" id="selected-categories"
                                                value="{{ $product->category }}">
                                        </div>

                                        @if (Auth::class && Auth::user()->role != 'user')
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">img</label>
                                                    <input class="form-control" type="file" id="formFile"
                                                        name="img">
                                                </div>
                                            </div>
                                        @endif

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">size</label>
                                                <select name="size" id="sizes" class="form-select"
                                                    aria-label="Default select example">
                                                    <option value="" selected>-Select-</option>
                                                    <option value="S" {{ $product->size == 'S' ? 'selected' : '' }}>
                                                        Small</option>
                                                    <option value="M" {{ $product->size == 'M' ? 'selected' : '' }}>
                                                        Medium</option>
                                                    <option value="L" {{ $product->size == 'L' ? 'selected' : '' }}>
                                                        Large</option>
                                                    <option value="XL" {{ $product->size == 'XL' ? 'selected' : '' }}>
                                                        Extra Large</option>
                                                    <option value="XXL" {{ $product->size == 'XXL' ? 'selected' : '' }}>
                                                        XXL</option>
                                                </select>


                                                @error('size')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <label for="myEditor">Suggestions</label>
                                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                            You can find your old suggestion below this suggestion box
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <textarea id="myEditor" name="suggestion"></textarea>
                                            <div class="my-3 prd-suggest">
                                                <h1 class="text-primary text-center">Your Suggestion </h1>
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                    role="alert">
                                                    Click-Img to view full screen
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="my-3 text-center">{!! $product->suggestion !!}</div>
                                            </div>
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
            if (existingItems.some(item => item.textContent.trim() === name)) {
                return;
            }

            // Create item element
            const itemElement = document.createElement('span');
            itemElement.classList.add('selected-item');
            itemElement.setAttribute('data-name', name); // Store name as data-name
            itemElement.textContent = name;

            // Add remove functionality on click
            const removeButton = document.createElement('span');
            removeButton.textContent = '×';
            removeButton.classList.add('remove-item');
            removeButton.addEventListener('click', function() {
                itemElement.remove();
                updateHiddenInput();
            });

            itemElement.appendChild(removeButton);

            selectedItemsContainer.appendChild(itemElement);
            updateHiddenInput();
        }

        // Add remove functionality to the pre-existing categories loaded from the backend
        document.querySelectorAll('.selected-item .remove-item').forEach(function(button) {
            button.addEventListener('click', function() {
                const itemElement = button.parentElement;
                itemElement.remove();
                updateHiddenInput();
            });
        });

        function updateHiddenInput() {
            const selectedNames = Array.from(document.querySelectorAll('.selected-item'))
                .map(item => item.getAttribute('data-name')); // Get names, not IDs
            document.getElementById('selected-categories').value = selectedNames.join(','); // Join names with commas
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Select all the images inside the suggestion content
            const images = document.querySelectorAll('.prd-suggest img');

            // Loop through each image and wrap it in a link
            images.forEach(function(image) {
                const imgSrc = image.getAttribute('src'); // Get the image source
                const link = document.createElement('a'); // Create a new anchor tag
                link.setAttribute('href', imgSrc); // Set the href to the image source
                link.setAttribute('target', '_blank'); // Open in a new tab

                // Wrap the image with the anchor tag
                image.parentNode.insertBefore(link, image);
                link.appendChild(image); // Append the image inside the link
            });
        });
    </script>
@endsection
