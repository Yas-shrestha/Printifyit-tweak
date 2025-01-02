@extends('backend.layouts.main')
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
                    <img src="{{ asset($order->product->front_img ?? 'https://via.placeholder.com/400x500') }}"
                        alt="Product Preview" id="product-preview" class="img-fluid tshirt">
                    <canvas id="canvas-overlay"></canvas>
                </div>

                <div class="mt-3 d-flex justify-content-center gap-3 tab-images">
                    <img src="{{ asset($order->product->front_img ?? 'https://via.placeholder.com/60x80') }}" alt="Front"
                        class="border active" data-view="front" id="front-view">
                    <img src="{{ asset($order->product->back_img ?? 'https://via.placeholder.com/60x80') }}" alt="Back"
                        class="border" data-view="back" id="back-view">
                    <img src="{{ asset($order->product->right_img ?? 'https://via.placeholder.com/60x80') }}" alt="Right"
                        class="border" data-view="right" id="right-view">
                    <img src="{{ asset($order->product->left_img ?? 'https://via.placeholder.com/60x80') }}" alt="Left"
                        class="border" data-view="left" id="left-view">
                </div>
            </div>

            <!-- Right Panel -->
            <div class="col-md-3">
                <h5 class="mb-3">{{ $order->product->name }}</h5>

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
@endsection
