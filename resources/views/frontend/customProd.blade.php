@extends('layouts.frontend')
@section('container')
    <style>
        .customization-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .preview-box {
            position: relative;
            /* border: 1px solid #ccc; */
            /* border-radius: 5px; */
            padding: 20px;
            /* background-color: #f5f5f5; */
        }

        .preview-box img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .preview-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
        }

        .preview-controls button {
            border: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-controls button:hover {
            background-color: #eee;
        }

        .tab-images img {
            width: 60px;
            height: auto;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
        }

        .tab-images img.active {
            border: 2px solid #007bff;
        }

        /* prod */
        .position-relative {
            position: relative;
        }

        #canvas-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: all;
            z-index: 1;
        }

        .tshirt {
            width: 100%;
        }

        .tab-images img {
            width: 60px;
            height: 80px;
            cursor: pointer;
        }

        .tab-images img.active {
            border: 2px solid #000;
        }

        .color-swatch.active,
        .size-swatch.active {
            border: 2px solid #007bff;
            /* Blue border to indicate selection */
            box-shadow: 0 0 5px #007bff;
        }
    </style>
    <div class="container my-5">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="d-flex flex-column gap-4">
                    <!-- Upload Button -->
                    <button class="btn btn-light text-start" id="upload-btn">
                        <i class="fas fa-upload me-2"></i> Upload
                    </button>
                    <hr>
                    <button class="btn btn-light text-start" id="remove-btn"> <i class="fa fa-minus" aria-hidden="true"></i>
                        Remove</button>
                    <button class="btn btn-light text-start"><i class="fas fa-redo me-2"></i> Redo</button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-6">
                <div class="preview-box text-center position-relative">
                    <!-- Default product image -->
                    <img src="{{ asset($product->front_img ?? 'https://via.placeholder.com/400x500') }}"
                        alt="Product Preview" id="product-preview" class="img-fluid tshirt">

                    <!-- Canvas Overlay -->
                    <canvas id="canvas-overlay"></canvas>
                </div>

                <div class="mt-3 d-flex justify-content-center gap-3 tab-images">
                    <img src="{{ asset($product->front_img ?? 'https://via.placeholder.com/60x80') }}" alt="Front"
                        class="border active" data-view="front" id="front-view">
                    <img src="{{ asset($product->back_img ?? ($product->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Back" class="border" data-view="back" id="back-view">
                    <img src="{{ asset($product->right_img ?? ($product->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Right" class="border" data-view="right" id="right-view">
                    <img src="{{ asset($product->left_img ?? ($product->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Left" class="border" data-view="left" id="left-view">
                </div>

                <!-- Hidden File Input -->
            </div>
            <!-- Right Panel -->
            <div class="col-md-3">
                <form id="product-form" method="POST" action="{{ route('custom.save', $product->id) }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name Your Creation</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId"
                            placeholder="" />
                    </div>

                    <h5 class="mb-3">{{ $product->name }}</h5>

                    <a href="#" class="text-primary">See product details</a>
                    <div class="mt-3">
                        <h6>Product Color</h6>
                        <div class="d-flex gap-2">
                            @if (!empty($product->color))
                                @php
                                    // Decode the JSON string into an array
                                    $colors = json_decode($product->color, true);
                                @endphp

                                @if (count($colors) > 0)
                                    <div class="d-flex gap-2">
                                        @foreach ($colors as $color)
                                            <div class="color-swatch"
                                                style="background: {{ $color }}; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;"
                                                data-color="{{ $color }}">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No colors available for this product.</p>
                                @endif
                            @else
                                <p>No colors available for this product.</p>
                            @endif

                        </div>

                    </div>
                    <div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
                        Please choose the color
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="mt-3">
                        <h6>Product Sizes</h6>
                        <div class="d-flex gap-2">
                            @if (!empty($product->size))
                                @php
                                    // Decode the JSON string into an array for sizes
                                    $sizes = json_decode($product->size, true);
                                @endphp

                                @if (count($sizes) > 0)
                                    <div class="d-flex gap-2">
                                        @foreach ($sizes as $size)
                                            <div class="size-swatch"
                                                style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;"
                                                data-size="{{ $size }}">
                                                {{ $size }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No sizes available for this product.</p>
                                @endif
                            @else
                                <p>No sizes available for this product.</p>
                            @endif

                        </div>
                    </div>
                    <div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
                        Please choose the size
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @csrf
                    <input type="hidden" name="selected_color" id="selected-color">
                    <input type="hidden" name="selected_size" id="selected-size">
                    <input type="hidden" name="canvas_data" id="canvas-data">
                    <input type="file" id="image-upload" class="form-control" style="display: none;" accept="image/*">
                    <button type="submit" class="btn btn-primary mt-3">Save Customization</button>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>


    <script>
        // Toggle preview tabs
        document.querySelectorAll('.tab-images img').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelector('.tab-images img.active').classList.remove('active');
                this.classList.add('active');
                const view = this.getAttribute('alt').toLowerCase();
                const previewImage = document.getElementById('product-preview');
                previewImage.src = this.src; // Use the same source as the clicked thumbnail
            });
        });
        // prod-view
    </script>


    <script>
        document.getElementById('product-form').addEventListener('submit', function(e) {
            // Prevent default form submission
            e.preventDefault();

            // Get selected color
            const activeColorElement = document.querySelector('.color-swatch.active');
            const selectedColor = activeColorElement ? activeColorElement.dataset.color : null;

            // Get selected size
            const activeSizeElement = document.querySelector('.size-swatch.active');
            const selectedSize = activeSizeElement ? activeSizeElement.dataset.size : null;

            // Gather canvas data for all views
            const canvasData = {};
            Object.keys(views).forEach((viewKey) => {
                const view = views[viewKey];
                if (view.image) {
                    canvasData[viewKey] = {
                        image: view.image.src, // Image source
                        x: view.x, // X position
                        y: view.y, // Y position
                        width: view.width, // Width
                        height: view.height, // Height
                    };
                }
            });

            // Populate hidden inputs
            document.getElementById('selected-color').value = selectedColor;
            document.getElementById('selected-size').value = selectedSize;
            document.getElementById('canvas-data').value = JSON.stringify(canvasData);

            // Submit the form
            this.submit();
        });
    </script>

    <script>
        //highlight selected color and size
        document.addEventListener('DOMContentLoaded', () => {
            const colorSwatches = document.querySelectorAll('.color-swatch');
            const sizeSwatches = document.querySelectorAll('.size-swatch');
            const selectedColorInput = document.getElementById('selected-color');
            const selectedSizeInput = document.getElementById('selected-size');

            // Handle color selection
            colorSwatches.forEach(swatch => {
                swatch.addEventListener('click', () => {
                    // Remove 'active' class from all swatches
                    colorSwatches.forEach(s => s.classList.remove('active'));
                    // Add 'active' class to the selected swatch
                    swatch.classList.add('active');
                    // Set the value in the hidden input
                    selectedColorInput.value = swatch.getAttribute('data-color');
                });
            });

            // Handle size selection
            sizeSwatches.forEach(swatch => {
                swatch.addEventListener('click', () => {
                    // Remove 'active' class from all swatches
                    sizeSwatches.forEach(s => s.classList.remove('active'));
                    // Add 'active' class to the selected swatch
                    swatch.classList.add('active');
                    // Set the value in the hidden input
                    selectedSizeInput.value = swatch.getAttribute('data-size');
                });
            });
        });
    </script>

    <script>
        const canvas = document.getElementById("canvas-overlay");
        const ctx = canvas.getContext("2d");
        const imageUpload = document.getElementById("image-upload");
        const uploadBtn = document.getElementById("upload-btn");
        const removeBtn = document.getElementById("remove-btn");
        const viewTabs = document.querySelectorAll(".tab-images img");

        const previewBox = document.querySelector(".preview-box");

        // Set canvas dimensions
        canvas.width = previewBox.offsetWidth;
        canvas.height = previewBox.offsetHeight;

        // State object for storing view-specific data
        const views = {
            front: {
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0
            },
            back: {
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0
            },
            right: {
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0
            },
            left: {
                image: null,
                x: 0,
                y: 0,
                width: 0,
                height: 0
            },
        };

        let currentView = "front"; // Default view
        let isDragging = false;
        let isResizing = false;
        let resizeHandleSize = 10;
        let currentHandleIndex = null;

        // Define red-marked area
        const redBoxX = canvas.width * 0.2;
        const redBoxY = canvas.height * 0.2;
        const redBoxWidth = canvas.width * 0.6;
        const redBoxHeight = canvas.height * 0.6;

        // Function to draw the red-marked area
        function drawBox() {
            ctx.strokeStyle = "red";
            ctx.lineWidth = 3;
            ctx.strokeRect(redBoxX, redBoxY, redBoxWidth, redBoxHeight);
        }

        // Function to draw the image and handles
        function drawCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drawBox();

            const view = views[currentView];
            if (view.image) {
                ctx.drawImage(view.image, view.x, view.y, view.width, view.height);
                drawHandles(view);
            }
        }

        // Draw resize handles at each corner of the image
        function drawHandles(view) {
            const handles = getHandles(view);
            ctx.fillStyle = "blue";
            handles.forEach(({
                x,
                y
            }) => {
                ctx.fillRect(x - resizeHandleSize / 2, y - resizeHandleSize / 2, resizeHandleSize,
                    resizeHandleSize);
            });
        }

        // Get the positions of resize handles
        function getHandles(view) {
            return [{
                    x: view.x,
                    y: view.y
                }, // Top-left
                {
                    x: view.x + view.width,
                    y: view.y
                }, // Top-right
                {
                    x: view.x,
                    y: view.y + view.height
                }, // Bottom-left
                {
                    x: view.x + view.width,
                    y: view.y + view.height
                }, // Bottom-right
            ];
        }

        // Handle image upload

        // Switch views and render respective view-specific images
        viewTabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                viewTabs.forEach((tab) => tab.classList.remove("active")); // Remove active from all tabs
                tab.classList.add("active"); // Add active to clicked tab

                currentView = tab.dataset.view; // Set the currentView based on data-view
                drawCanvas(); // Redraw canvas with the new view
            });
        });
        imageUpload.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    const img = new Image();
                    img.onload = () => {
                        const view = views[
                            currentView]; // Use the currentView to determine where to store the image
                        view.image = img;

                        // Center image in the red box
                        view.width = redBoxWidth * 0.5;
                        view.height = (img.height / img.width) * view.width;
                        view.x = redBoxX + (redBoxWidth - view.width) / 2;
                        view.y = redBoxY + (redBoxHeight - view.height) / 2;

                        drawCanvas(); // Redraw canvas after image load
                    };
                    img.src = event.target.result; // Load image data
                };
                reader.readAsDataURL(file);
            }
        });
        removeBtn.addEventListener("click", () => {
            const view = views[currentView];
            view.image = null;
            view.x = 0;
            view.y = 0;
            view.width = 0;
            view.height = 0;
            drawCanvas();
        });
        // Mouse events for dragging and resizing
        canvas.addEventListener("mousedown", (e) => {
            const mouseX = e.offsetX;
            const mouseY = e.offsetY;
            const view = views[currentView];
            const handles = getHandles(view);

            // Check if mouse is over a resize handle
            currentHandleIndex = handles.findIndex((handle) =>
                mouseX >= handle.x - resizeHandleSize / 2 &&
                mouseX <= handle.x + resizeHandleSize / 2 &&
                mouseY >= handle.y - resizeHandleSize / 2 &&
                mouseY <= handle.y + resizeHandleSize / 2
            );

            if (currentHandleIndex !== -1) {
                isResizing = true;
                return;
            }

            // Check if mouse is over the image
            if (
                mouseX >= view.x &&
                mouseX <= view.x + view.width &&
                mouseY >= view.y &&
                mouseY <= view.y + view.height
            ) {
                isDragging = true;
            }
        });

        canvas.addEventListener("mousemove", (e) => {
            const mouseX = e.offsetX;
            const mouseY = e.offsetY;
            const view = views[currentView];


            if (isDragging) {
                // Dragging logic
                view.x = mouseX - view.width / 2;
                view.y = mouseY - view.height / 2;

                // Restrict dragging to the red-marked box
                view.x = Math.max(redBoxX, Math.min(view.x, redBoxX + redBoxWidth - view.width));
                view.y = Math.max(redBoxY, Math.min(view.y, redBoxY + redBoxHeight - view.height));

                drawCanvas();
            } else if (isResizing && currentHandleIndex !== null) {
                // Resizing logic
                const handles = getHandles(view);
                const handle = handles[currentHandleIndex];

                if (currentHandleIndex === 0) {
                    // Top-left
                    const newWidth = view.x + view.width - mouseX;
                    const newHeight = view.y + view.height - mouseY;
                    if (newWidth > 20 && newHeight > 20) {
                        view.width = newWidth;
                        view.height = newHeight;
                        view.x = mouseX;
                        view.y = mouseY;
                    }
                } else if (currentHandleIndex === 1) {
                    // Top-right
                    const newWidth = mouseX - view.x;
                    const newHeight = view.y + view.height - mouseY;
                    if (newWidth > 20 && newHeight > 20) {
                        view.width = newWidth;
                        view.height = newHeight;
                        view.y = mouseY;
                    }
                } else if (currentHandleIndex === 2) {
                    // Bottom-left
                    const newWidth = view.x + view.width - mouseX;
                    const newHeight = mouseY - view.y;
                    if (newWidth > 20 && newHeight > 20) {
                        view.width = newWidth;
                        view.height = newHeight;
                        view.x = mouseX;
                    }
                } else if (currentHandleIndex === 3) {
                    // Bottom-right
                    const newWidth = mouseX - view.x;
                    const newHeight = mouseY - view.y;
                    if (newWidth > 20 && newHeight > 20) {
                        view.width = newWidth;
                        view.height = newHeight;
                    }
                }

                drawCanvas();
            }
        });

        canvas.addEventListener("mouseup", () => {
            isDragging = false;
            isResizing = false;
            currentHandleIndex = null;
        });

        // Trigger file upload
        uploadBtn.addEventListener("click", () => {
            imageUpload.click();
        });

        // Initial canvas setup
        drawCanvas();
    </script>
@endsection
