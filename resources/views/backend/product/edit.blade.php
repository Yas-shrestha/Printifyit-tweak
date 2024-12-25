@extends('backend.layouts.main')
@section('container')
    <style>
        #size-options {
            gap: 12px;
        }

        .size-option {
            position: relative;
        }

        .size-option input[type="checkbox"] {
            display: none;
            /* Hide default checkbox */
        }

        .size-option .size-label {
            display: inline-block;
            padding: 8px 16px;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .size-option .size-label:hover {
            border-color: #007bff;
            background-color: #e9ecef;
        }

        .size-option input[type="checkbox"]:checked+.size-label {
            border-color: #007bff;
            background-color: #007bff;
            color: white;
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

                </div><!-- End Page Title -->

                <div class="bg-warning p-3 rounded-3 my-3 text-white">You can also insert only 1 images just insert it on
                    front_img
                </div>
                <section class="section">
                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('product.store', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">name</label>
                                                <input type="text" class="form-control" id="exampleInputText1"
                                                    aria-describedby="textHelp" name="name" value="{{ $product->name }}">
                                                @error('name')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">price</label>
                                                <input type="number" class="form-control" id="exampleInputText1"
                                                    aria-describedby="textHelp" name="price"
                                                    value="{{ $product->price }}">
                                                @error('price')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="color-form" class="form-label">Choose Colors</label>
                                                <div id="color-inputs-container">
                                                    <!-- Check if $product->color is not null and decode it, else use an empty array -->
                                                    @foreach (json_decode($product->color, true) ?? [] as $color)
                                                        <div class="color-input-wrapper"
                                                            style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                                                            <input type="color" class="form-control color-picker"
                                                                name="colors[]" value="{{ $color }}"
                                                                style="width: 60px;">
                                                            <input type="text" class="form-control hex-input"
                                                                name="colors[]" value="{{ $color }}" maxlength="7"
                                                                style="width: 100px;">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-color-btn">Remove</button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!-- Add new color input area -->
                                                <div id="color-input-wrapper-template" style="display: none;">
                                                    <div class="color-input-wrapper"
                                                        style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                                                        <input type="color" class="form-control color-picker"
                                                            name="colors[]" value="#000000" style="width: 60px;">
                                                        <input type="text" class="form-control hex-input" name="colors[]"
                                                            placeholder="#000000" maxlength="7" style="width: 100px;">
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-color-btn">Remove</button>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-primary add-color-btn">Add</button>
                                                <div id="color-preview-container"
                                                    style="margin-top: 15px; display: flex; gap: 10px;"></div>
                                                @error('colors')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="size-options" class="form-label">Sizes</label>
                                                <div id="size-options" style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                    <!-- Check if $product->size is not null and decode it, else use an empty array -->
                                                    @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                                        <div class="size-option">
                                                            <input type="checkbox" id="size-{{ strtolower($size) }}"
                                                                name="size[]" value="{{ $size }}"
                                                                {{ in_array($size, json_decode($product->size, true) ?? []) ? 'checked' : '' }}>
                                                            <label for="size-{{ strtolower($size) }}"
                                                                class="size-label">{{ $size }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <small>Click to choose sizes.</small>
                                                @error('size')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="stock-form" class="form-label">Stock</label>
                                                <input type="number" class="form-control" id="stock-form"
                                                    aria-describedby="textHelp" name="stock"
                                                    value="{{ $product->stock }}">
                                                @error('stock')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="front_img" class="form-label">Front Img</label>
                                                <input class="form-control" type="file" id="front_img"
                                                    name="front_img">

                                                @if ($product->front_img)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($product->front_img) }}" alt="Front Image"
                                                            class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                @endif

                                                @error('front_img')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="back_img" class="form-label">Back Img</label>
                                                <input class="form-control" type="file" id="back_img"
                                                    name="back_img">

                                                @if ($product->back_img)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($product->back_img) }}" alt="Back Image"
                                                            class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                @endif

                                                @error('back_img')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="left_img" class="form-label">Left Img</label>
                                                <input class="form-control" type="file" id="left_img"
                                                    name="left_img">

                                                @if ($product->left_img)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($product->left_img) }}" alt="Left Image"
                                                            class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                @endif

                                                @error('left_img')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="mb-3">
                                                <label for="right_img" class="form-label">Right Img</label>
                                                <input class="form-control" type="file" id="right_img"
                                                    name="right_img">

                                                @if ($product->right_img)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($product->right_img) }}" alt="Right Image"
                                                            class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                @endif

                                                @error('right_img')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="mb-3">
                                                <label for="exampleInputText1" class="form-label">description</label>
                                                <textarea id="myEditor" name="description"> {{ $product->description }}</textarea>
                                                @error('description')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>


                                        {{-- <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label for="myEditor">Suggestions</label>
                                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                Please give every detail you want and be as much specific as you can for
                                                precise
                                                design and also mention what product we are working on For ex:- Tshirt,Pant
                                                etc
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div> --}}
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
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputsContainer = document.getElementById('color-inputs-container');
            const colorPreviewContainer = document.getElementById('color-preview-container');
            const addColorBtn = document.querySelector('.add-color-btn');
            const colorInputTemplate = document.getElementById('color-input-wrapper-template');

            // Add a new color input
            function addColorInput() {
                const colorWrapper = colorInputTemplate.firstElementChild.cloneNode(true);
                colorInputsContainer.appendChild(colorWrapper);
                syncColorPickerWithHexInput(colorWrapper);
                updateColorPreviews();
            }

            // Remove color input
            colorInputsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-color-btn')) {
                    event.target.parentElement.remove();
                    updateColorPreviews();
                }
            });

            // Update the preview container
            function updateColorPreviews() {
                colorPreviewContainer.innerHTML = '';
                const colorPickers = document.querySelectorAll('.color-picker');
                colorPickers.forEach(colorPicker => {
                    const colorBlock = document.createElement('div');
                    colorBlock.style.width = '50px';
                    colorBlock.style.height = '50px';
                    colorBlock.style.backgroundColor = colorPicker.value;
                    colorBlock.style.border = '1px solid #000';
                    colorPreviewContainer.appendChild(colorBlock);

                    colorPicker.addEventListener('input', () => {
                        colorBlock.style.backgroundColor = colorPicker.value;
                    });
                });
            }

            // Sync color picker and hex input
            function syncColorPickerWithHexInput(wrapper) {
                const colorPicker = wrapper.querySelector('.color-picker');
                const hexInput = wrapper.querySelector('.hex-input');

                colorPicker.addEventListener('input', () => {
                    hexInput.value = colorPicker.value;
                    updateColorPreviews();
                });

                hexInput.addEventListener('input', () => {
                    const hexValue = hexInput.value;
                    if (/^#([0-9A-Fa-f]{6})$/.test(hexValue)) {
                        colorPicker.value = hexValue;
                        updateColorPreviews();
                    }
                });
            }

            // Initialize the first color picker and hex input sync
            const initialColorWrapper = document.querySelector('.color-input-wrapper');
            syncColorPickerWithHexInput(initialColorWrapper);
            updateColorPreviews();

            // Add event listener for the Add Color button
            addColorBtn.addEventListener('click', function() {
                addColorInput();
            });
        });
    </script>

    <script>
        tinymce.init({
            selector: '#myEditor', // Target the specific textarea
            plugins: [
                // Essential plugins
                'image', 'link', 'lists', 'media', 'table', 'wordcount',
                // Optional extras
                'emoticons', 'charmap', 'searchreplace', 'visualblocks'

            ],
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | numlist bullist  ',
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
        document.addEventListener('DOMContentLoaded', function() {
            const sizeInputsContainer = document.getElementById('size-inputs-container');
            const sizePreviewContainer = document.getElementById('size-preview-container');

            // Add a new size input
            function addSizeInput() {
                const sizeWrapper = document.createElement('div');
                sizeWrapper.classList.add('size-input-wrapper');
                sizeWrapper.style.marginBottom = '10px';
                sizeWrapper.style.display = 'flex';
                sizeWrapper.style.alignItems = 'center';
                sizeWrapper.style.gap = '10px';

                sizeWrapper.innerHTML = `
                <input type="text" class="form-control size-input" name="size[]" placeholder="Enter size (e.g., S, M, L)" style="width: 200px;">
                <button type="button" class="btn btn-sm btn-danger remove-size-btn">Remove</button>
            `;

                sizeInputsContainer.appendChild(sizeWrapper);
                updateSizePreviews();
            }

            // Update the preview container
            function updateSizePreviews() {
                sizePreviewContainer.innerHTML = '';
                const sizeInputs = document.querySelectorAll('.size-input');
                sizeInputs.forEach(sizeInput => {
                    if (sizeInput.value.trim() !== '') {
                        const sizeBlock = document.createElement('div');
                        sizeBlock.style.padding = '5px 10px';
                        sizeBlock.style.border = '1px solid #000';
                        sizeBlock.style.borderRadius = '5px';
                        sizeBlock.style.backgroundColor = '#f1f1f1';
                        sizeBlock.innerText = sizeInput.value.trim();
                        sizePreviewContainer.appendChild(sizeBlock);

                        sizeInput.addEventListener('input', () => {
                            sizeBlock.innerText = sizeInput.value.trim();
                        });
                    }
                });
            }

            // Add event listeners for adding/removing sizes
            sizeInputsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-size-btn')) {
                    addSizeInput();
                    updateSizePreviews();
                } else if (event.target.classList.contains('remove-size-btn')) {
                    event.target.parentElement.remove();
                    updateSizePreviews();
                }
            });

            // Initialize the first size preview
            const initialSizeWrapper = document.querySelector('.size-input-wrapper .size-input');
            if (initialSizeWrapper) {
                initialSizeWrapper.addEventListener('input', updateSizePreviews);
            }
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
