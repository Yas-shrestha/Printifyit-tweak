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
            padding: 20px;
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
            height: 80px;
            cursor: pointer;
        }

        .tab-images img.active {
            border: 2px solid #000;
        }

        .color-swatch.active,
        .size-swatch.active {
            border: 2px solid #007bff;
            box-shadow: 0 0 5px #007bff;
        }

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

        .tab-images img.active {
            border: 2px solid #000;
        }
    </style>

    <div class="container my-5">

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="d-flex flex-column gap-4">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back</a>
                    <button class="btn btn-light text-start" id="upload-btn">
                        <i class="fas fa-upload me-2"></i> Upload
                    </button>
                    <hr>
                    <button class="btn btn-light text-start" id="remove-btn">
                        <i class="fa fa-minus" aria-hidden="true"></i> Remove
                    </button>
                    <button class="btn btn-light text-start"><i class="fas fa-redo me-2"></i> Redo</button>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-6">
                <div class="preview-box text-center position-relative">
                    <img src="{{ asset($order->customizedProducts->products->front_img ?? 'https://via.placeholder.com/400x500') }}"
                        alt="Product Preview" id="product-preview" class="img-fluid tshirt">
                    <canvas id="canvas-overlay"></canvas>
                </div>

                <div class="mt-3 d-flex justify-content-center gap-3 tab-images">
                    <img src="{{ asset($order->customizedProducts->products->front_img ?? 'https://via.placeholder.com/60x80') }}"
                        alt="Front" class="border active" data-view="front" id="front-view">
                    <img src="{{ asset($order->customizedProducts->products->back_img ?? 'https://via.placeholder.com/60x80') }}"
                        alt="Back" class="border" data-view="back" id="back-view">
                    <img src="{{ asset($order->customizedProducts->products->right_img ?? 'https://via.placeholder.com/60x80') }}"
                        alt="Right" class="border" data-view="right" id="right-view">
                    <img src="{{ asset($order->customizedProducts->products->left_img ?? 'https://via.placeholder.com/60x80') }}"
                        alt="Left" class="border" data-view="left" id="left-view">
                </div>
            </div>

            <!-- Right Panel -->
            <div class="col-md-3">
                <h5 class="mb-3">{{ $order->customizedProducts->products->name }}</h5>

                <div class="mt-3">
                    <h6>Product Color</h6>
                    <div class="d-flex gap-2">
                        <div class="color-swatch"
                            style="background: {{ $order->color }}; width: 30px; height: 30px; border-radius: 50%; cursor: pointer;"
                            data-color="{{ $order->color }}"></div>
                    </div>
                </div>

                <div class="mt-3">
                    <h6>Product Sizes</h6>
                    <div class="d-flex gap-2">
                        <div class="size-swatch"
                            style="padding: 5px 10px; border: 1px solid #ccc; border-radius: 5px; cursor: pointer;"
                            data-size="{{ $order->size }}">
                            {{ $order->size }}
                        </div>
                    </div>
                </div>
                <div class="my-3">
                    <h6>Add To Cart</h6>
                    <form action="{{ route('carts.store') }}" method="POST" enctype="multipart/form-data" class="pb-2">
                        @csrf
                        <input type="hidden" name="color" id="color" value="{{ $order->color }}">
                        <input type="hidden" name="size" id="size" value="{{ $order->size }}">
                        <button type="button" class="btn btn-link px-2"
                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                            <i class="fa fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" min="1" max="20" style="width: 40px"
                            value="1">
                        <button type="button" class="btn btn-link px-2"
                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                            <i class="fa fa-plus"></i>
                        </button>
                        <input type="number" name="customProd_id" value="{{ $order->id }}" readonly
                            style="display: none;">
                        <button type="submit" class="btn btn-primary" title="Add to cart"><i
                                class="fa-solid fa-cart-shopping"></i></button>
                    </form>
                </div>
                <div class="canvas-container mt-3">
                    @if (!empty($canvasData))
                        @foreach ($canvasData as $side => $data)
                            <div>
                                <h6>{{ ucfirst($side) }}</h6>
                                <img src="{{ asset('uploads/canvas_images/' . $data['image']) }}"
                                    alt="{{ $side }} view" style="max-width: 100%;"
                                    data-side="{{ $side }}" data-x="{{ $data['x'] }}"
                                    data-y="{{ $data['y'] }}" data-width="{{ $data['width'] }}"
                                    data-height="{{ $data['height'] }}" height="200px" width="100%"
                                    style="object-fit: cover">
                            </div>
                        @endforeach
                    @else
                        <p>No customization data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <input type="file" id="image-upload" style="display:none;">


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
        const canvasData = @json($canvasData);
        const canvas = document.getElementById("canvas-overlay");
        const ctx = canvas.getContext("2d");
        const viewTabs = document.querySelectorAll(".tab-images img");

        const previewBox = document.querySelector(".preview-box");

        // Ensure the canvas size matches the preview box
        canvas.width = previewBox.offsetWidth;
        canvas.height = previewBox.offsetHeight;

        // State object for storing view-specific data (canvas data from backend)
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

        // Initialize canvas data (this part should load canvas data from the backend)
        Object.keys(views).forEach((view) => {
            if (canvasData[view]) {
                const viewData = canvasData[view];
                views[view] = {
                    image: new Image(),
                    x: viewData.x,
                    y: viewData.y,
                    width: viewData.width,
                    height: viewData.height,
                };

                // Set image source based on the backend data
                views[view].image.src = `{{ asset('uploads/canvas_images/') }}/${viewData.image}`;

                views[view].image.onload = () => {
                    // Ensure the image is drawn correctly
                    drawCanvas();
                };
            }
        });

        // Function to draw the image on the canvas
        function drawCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Clear the canvas

            const view = views[currentView];
            if (view.image) {
                // Use the exact x, y, width, and height provided by the backend without altering
                ctx.drawImage(view.image, view.x, view.y, view.width, view.height);
            }
        }

        // Switch views and render respective view-specific images
        viewTabs.forEach((tab) => {
            tab.addEventListener("click", () => {
                viewTabs.forEach((tab) => tab.classList.remove("active"));
                tab.classList.add("active");

                currentView = tab.dataset.view;
                drawCanvas(); // Redraw canvas with the new view
            });
        });

        // Initial canvas setup
        drawCanvas();
    </script>


@endsection
