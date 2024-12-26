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
                    <img src="{{ asset($customs->products->front_img ?? 'https://via.placeholder.com/400x500') }}"
                        alt="Product Preview" id="product-preview" class="img-fluid tshirt">

                    <!-- Canvas Overlay -->
                    <canvas id="canvas-overlay"></canvas>
                </div>

                <div class="mt-3 d-flex justify-content-center gap-3 tab-images">
                    <img src="{{ asset($customs->products->front_img ?? 'https://via.placeholder.com/60x80') }}"
                        alt="Front" class="border active" data-view="front" id="front-view">
                    <img src="{{ asset($customs->products->back_img ?? ($customs->products->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Back" class="border" data-view="back" id="back-view">
                    <img src="{{ asset($customs->products->right_img ?? ($customs->products->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Right" class="border" data-view="right" id="right-view">
                    <img src="{{ asset($customs->products->left_img ?? ($customs->products->front_img ?? 'https://via.placeholder.com/60x80')) }}"
                        alt="Left" class="border" data-view="left" id="left-view">
                </div>

                <!-- Hidden File Input -->
            </div>
            <!-- Right Panel -->
            <div class="col-md-3">
                <h5 class="mb-3">{{ $customs->products->name }}</h5>
                <a href="#" class="text-primary">See product details</a>
                <div class="mt-3">
                    <h6>Product Color</h6>
                    <div class="d-flex gap-2">
                        <div class="color-swatch"
                            style="background: {{ $customs->color }}; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;}}"
                            data-color="{{ $customs->color }}">
                        </div>

                    </div>
                </div>
                <div class="mt-3">
                    <h6>Product Sizes</h6>
                    <div class="d-flex gap-2">
                        <div class="size-swatch"
                            style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;"
                            data-size="{{ $customs->size }}">
                            {{ $customs->size }}
                        </div>

                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="canvas-container">
                        @if (!empty($canvasData))
                            @foreach ($canvasData as $side => $url)
                                <div>
                                    <h6>{{ ucfirst($side) }}</h6>
                                    <img src="{{ asset($url) }}" alt="{{ $side }} view"
                                        style="max-width: 100%;">
                                </div>
                            @endforeach
                        @else
                            <p>No canvas data available.</p>
                        @endif
                    </div>
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
        // Mouse events for dragging and resizing

        // Initial canvas setup
        drawCanvas();
    </script>
@endsection
