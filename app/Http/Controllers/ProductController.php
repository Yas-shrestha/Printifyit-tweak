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
        $products = Product::query()->where('user_id', Auth::id())->paginate(10);
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
        // dd($request);
        $product = new Product;
        $request->validate([
            'name' => 'required|string',
            'img' => 'nullable|mimes:png,jpg,jpeg',
            'category' => 'nullable',
            'suggestion' => 'required',

        ]);
        $user_id = Auth::user()->id;
        $product->user_id = $user_id; // Assuming the Product model has a user_id column
        $product->name = $request->input('name');
        $product->color = $request->input('color');
        $product->size = $request->input('size');
        $product->category = $request->input('selected_categories');
        $suggestionContent = $request->input('suggestion');

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress errors due to malformed HTML
        $dom->loadHTML($suggestionContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        // Process each image
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');

            // Check if the src is in base64 format
            if (strpos($src, 'data:image') === 0) {
                // Extract the base64 data
                list($type, $data) = explode(';', $src);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                // Define a unique filename and save the image
                $imageName = uniqid() . '.png';
                $path = public_path('suggestion_images/' . $imageName);
                file_put_contents($path, $data);

                // Replace the base64 src with the saved image URL
                $img->setAttribute('src', asset('suggestion_images/' . $imageName));
            }
        }

        // Save the modified suggestion content
        $product->suggestion = $dom->saveHTML();

        // Handle the optional image upload
        if ($request->hasFile('img')) {
            // Get the file from the request
            $file = $request->file('img');

            // Create a nice filename using the product name and extension
            $imageName = Str::slug($product->name) . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the public/uploads folder
            $file->move(public_path('uploads'), $imageName);

            // Save the image path in the database
            $product->img_path = 'uploads/' . $imageName; // Save only the relative path in the database
        }
        // Save the product to the database
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
        $product = Product::findOrFail($id);

        // Validate the input
        $request->validate([
            'name' => 'required|string',
            'img' => 'nullable',

            'suggestion' => 'nullable', // Allow suggestion to be null
        ]);

        // Update the product fields
        $product->name = $request->input('name');
        $product->color = $request->input('color');
        $product->size = $request->input('size');
        $product->category = $request->input('selected_categories');

        // If the suggestion has been updated
        if ($request->has('suggestion') && $request->input('suggestion') !== null) {
            // Delete old images from the previous suggestion
            $this->deleteOldImagesFromSuggestion($product->suggestion);

            // New suggestion content
            $suggestionContent = $request->input('suggestion');

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true); // Suppress errors due to malformed HTML
            $dom->loadHTML($suggestionContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            libxml_clear_errors();

            // Process each image in the suggestion content
            $images = $dom->getElementsByTagName('img');
            foreach ($images as $img) {
                $src = $img->getAttribute('src');

                // Check if the src is in base64 format
                if (strpos($src, 'data:image') === 0) {
                    // Extract the base64 data
                    list($type, $data) = explode(';', $src);
                    list(, $data) = explode(',', $data);
                    $data = base64_decode($data);

                    // Define a unique filename and save the image
                    $imageName = uniqid() . '.png';
                    $path = public_path('suggestion_images/' . $imageName);
                    file_put_contents($path, $data);

                    // Replace the base64 src with the saved image URL
                    $img->setAttribute('src', asset('suggestion_images/' . $imageName));
                } else {
                    // Delete old image from suggestion if it exists and the src is not a base64 image
                    $this->deleteOldImageFromSuggestion($src);
                }
            }

            // Save the modified suggestion content
            $product->suggestion = $dom->saveHTML();
        }

        // Handle the optional image upload (product image)
        if ($request->hasFile('img')) {
            // Get the file from the request
            $file = $request->file('img');

            // Create a nice filename using the product name and extension
            $imageName = Str::slug($product->name) . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Move the file to the public/uploads folder
            $file->move(public_path('uploads'), $imageName);

            // Check if the product already has an existing image and delete it
            if ($product->img) {
                $existingImagePath = public_path($product->img);
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            // Save the new image path in the database
            $product->img = 'uploads/' . $imageName; // Save only the relative path in the database
        }

        // Save the updated product to the database
        $product->save();

        return redirect('/admin/product')->with('success', 'Product updated successfully!');
    }

    protected function deleteOldImagesFromSuggestion($oldSuggestion)
    {
        // Use regex to find all image URLs in the old suggestion content
        preg_match_all('/src="([^"]+)"/', $oldSuggestion, $matches);
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
    }

    protected function deleteOldImageFromSuggestion($src)
    {
        // Strip out the base URL to get the relative image path
        $relativePath = str_replace(asset('suggestion_images/'), '', $src);

        // Ensure it's a valid relative path
        if (!empty($relativePath)) {
            // Get the full path to the image inside the public folder
            $imagePath = public_path('suggestion_images/' . $relativePath);

            // Check if the image exists and delete it
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the file
            }
        }
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
