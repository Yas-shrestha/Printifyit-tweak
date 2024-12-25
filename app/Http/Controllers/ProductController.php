<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()->paginate(10);
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'stock' => 'required|numeric',
            'description' => 'required|string',
            'colors' => 'required|array',
            'colors.*' => 'string',
            'size' => 'required|array', // Ensure at least one size is selected
            'size.*' => 'in:XS,S,M,L,XL,XXL',
            'price' => 'required|numeric',
            'front_img' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            'back_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'right_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'left_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->color = json_encode($request->input('colors')); // Convert the array to JSON
        $product->size = json_encode($request->input('size'));   // Convert the array to JSON

        if ($request->hasFile('front_img')) {
            $file = $request->file('front_img');
            $uniqueName = 'front_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->front_img = 'products/' . $uniqueName;
        }

        if ($request->hasFile('back_img')) {
            $file = $request->file('back_img');
            $uniqueName = 'back_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->back_img = 'products/' . $uniqueName;
        }

        if ($request->hasFile('right_img')) {
            $file = $request->file('right_img');
            $uniqueName = 'right_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->right_img = 'products/' . $uniqueName;
        }

        if ($request->hasFile('left_img')) {
            $file = $request->file('left_img');
            $uniqueName = 'left_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->left_img = 'products/' . $uniqueName;
        }


        $product->save();

        return redirect('/admin/product')->with('success', 'Product added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::query()->where('id', $id)->first();
        return view('backend.product.view', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::query()->where('id', $id)->first();
        $files = File::query()->paginate(9);
        return view('backend.product.edit', compact('product', 'categories', 'files'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'color' => 'required|array',
            'color.*' => 'string',
            'size' => 'required|array',
            'size.*' => 'string',
            'price' => 'required|numeric',
            'front_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'back_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'right_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'left_img' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update basic fields
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->color = json_encode($request->input('color')); // Convert the array to JSON
        $product->size = json_encode($request->input('size'));   // Convert the array to JSON

        // Handle front image
        if ($request->hasFile('front_img')) {
            // Delete old image if exists
            if ($product->front_img && file_exists(public_path($product->front_img))) {
                unlink(public_path($product->front_img));
            }

            $file = $request->file('front_img');
            $uniqueName = 'front_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->front_img = 'products/' . $uniqueName;
        }

        // Handle back image
        if ($request->hasFile('back_img')) {
            if ($product->back_img && file_exists(public_path($product->back_img))) {
                unlink(public_path($product->back_img));
            }

            $file = $request->file('back_img');
            $uniqueName = 'back_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->back_img = 'products/' . $uniqueName;
        }

        // Handle right image
        if ($request->hasFile('right_img')) {
            if ($product->right_img && file_exists(public_path($product->right_img))) {
                unlink(public_path($product->right_img));
            }

            $file = $request->file('right_img');
            $uniqueName = 'right_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->right_img = 'products/' . $uniqueName;
        }

        // Handle left image
        if ($request->hasFile('left_img')) {
            if ($product->left_img && file_exists(public_path($product->left_img))) {
                unlink(public_path($product->left_img));
            }

            $file = $request->file('left_img');
            $uniqueName = 'left_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $uniqueName);
            $product->left_img = 'products/' . $uniqueName;
        }

        // Save updated product
        $product->save();

        return redirect('/admin/product')->with('success', 'Product updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the main image if it exists
        if ($product->img_path) {
            $imagePath = public_path($product->img_path); // Get the full path of the image
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        // Use a regex to find all image URLs in the suggestion
        preg_match_all('/src="([^"]+)"/', $product->suggestion, $matches);
        $existingImageUrls = $matches[1]; // Array of existing image URLs

        // Remove suggestion images from the filesystem
        foreach ($existingImageUrls as $existingImageUrl) {
            // Get the relative path by removing the base URL (asset URL)
            $existingImagePath = str_replace(asset(''), '', $existingImageUrl); // Remove the asset URL part
            $existingImagePath = public_path($existingImagePath); // Get the full path in the public folder

            // Check if the image exists and delete it
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath); // Delete the suggestion image file
            }
        }

        // Delete the product from the database
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
    // for changing product status
    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'product_status' => 'required|string',
        ]);

        $product = Product::query()->where('id', $id)->first();
        // Update the status
        $product->product_status = $request->product_status;
        $product->save();

        return redirect()->back()->with('msg', 'succesfully updated');
    }
    public function changeReqStatus(Request $request, $id)
    {

        $request->validate([
            'req_status' => 'required|string',
        ]);

        $product = Product::query()->where('id', $id)->first();
        // Update the status
        $product->req_status = $request->req_status;
        $product->save();

        return redirect()->back()->with('msg', 'succesfully updated');
    }
    public function updatePrice(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the price input
        $validated = $request->validate([
            'price' => 'required|numeric|min:1',  // Ensure price is a number and greater than or equal to 1
        ]);

        // Update the price
        $product->price = $request->price;
        $product->save();

        return redirect()->back()->with('success', 'Price updated successfully!');
    }
}
