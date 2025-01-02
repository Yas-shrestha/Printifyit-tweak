<?php

namespace App\Http\Controllers;

use App\Models\customizedProd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomizedProdController extends Controller
{
    public function Customization(Request $request, $id)
    {
        // Validate the request to ensure 'canvas_data', 'selected_color', and 'selected_size' are provided
        $request->validate([
            'canvas_data' => 'required|string',  // Ensure canvas_data is required and is a string
            'selected_color' => 'required|string', // Ensure selected_color is a string if provided
            'selected_size' => 'required|string',  // Ensure selected_size is a string if provided
            'name' => 'required|string',  // Ensure selected_size is a string if provided
        ]);

        // Extract the 'canvas_data' from the request
        $canvasData = $request->input('canvas_data');
        $selectedColor = $request->input('selected_color');
        $selectedSize = $request->input('selected_size');
        $name = $request->input('name');

        // Decode the JSON data to extract the image data
        $canvasData = json_decode($canvasData, true); // Decode the JSON to an associative array

        // Initialize an array to hold processed data for the views column
        $processedData = [];

        // Iterate through all sections (front, back, right, left, etc.)
        foreach (['front', 'back', 'right', 'left'] as $section) {
            // Check if the section exists in the canvas data and has an image
            if (isset($canvasData[$section]) && isset($canvasData[$section]['image'])) {
                $data = $canvasData[$section]; // Get the data for this section
                $imageData = $data['image']; // Base64 encoded image string

                // Validate the base64 format of the image (check for allowed image types)
                if (!preg_match('/^data:image\/(jpeg|png|jpg|gif);base64,/', $imageData)) {
                    return Redirect::back()->with('error', 'Invalid image format. Only JPEG, PNG, JPG, and GIF are allowed.');
                }

                // Extract the image extension (jpeg, png, etc.) dynamically for each image
                preg_match('/data:image\/(.*?);/', $imageData, $matches);
                $extension = $matches[1];  // e.g., 'jpeg'

                // Generate a unique filename for each image (based on the section name and a random string)
                $uniqueName = $section . '_' . Str::random(10) . '.' . $extension;

                // Decode the base64 image data
                $imageDataDecoded = base64_decode(preg_replace('/^data:image\/(.*?);base64,/', '', $imageData));

                // Ensure the image was decoded properly
                if ($imageDataDecoded === false) {
                    return Redirect::back()->with('error', 'Failed to decode image. Please try again.');
                }

                // Define the upload directory (public directory or custom path)
                $uploadDir = public_path('uploads/canvas_images');

                // Ensure the directory exists
                if (!File::exists($uploadDir)) {
                    File::makeDirectory($uploadDir, 0777, true);
                }

                // Define the full path for saving the image file
                $filePath = $uploadDir . '/' . $uniqueName;

                // Save the decoded image data to the server
                file_put_contents($filePath, $imageDataDecoded);

                // Store the image metadata and file path in the processed data for the current section
                $processedData[$section] = [
                    'image' => $uniqueName, // Store the unique name of the image
                    'x' => $data['x'],
                    'y' => $data['y'],
                    'width' => $data['width'],
                    'height' => $data['height'],
                ];
            }
        }

        // Now that all images and metadata are processed, store them in the database
        CustomizedProd::create([
            'product_id' => $id,
            'user_id' => Auth::user()->id, // Assuming the user is logged in
            'color' => $selectedColor, // Store the selected color
            'size' => $selectedSize, // Store the selected size
            'name' => $name, // Store the selected size
            'views' => json_encode($processedData), // Store the processed data as JSON
            'status' => 'pending', // Default status
            'customization_charge' => 200, // Default charge
        ]);

        // Return success message
        return Redirect::route('custom-products')->with('success', 'Customization saved successfully!');
    }



    public function viewCustomize($id)
    {
        // Check if the authenticated user has a customized product
        $user = Auth::user();

        // Check if the user has a record in the customizedProd table for the given ID
        $customs = customizedProd::query()
            ->where('id', $id)
            ->where('user_id', $user->id) // Assuming the customizedProd table has a user_id field to link to the user
            ->first();
        // If no record exists, redirect to the index page
        if (!$customs) {
            return redirect('/')->with('error', 'You do not have  customized product.');
        }
        // If record exists, proceed to view the product's data
        $canvasData = json_decode($customs->views ?? '{}', true);

        return view('frontend.customProd-view', compact('customs', 'canvasData'));
    }
    public function destroy($id)
    {
        // Find the CustomizedProd record by ID
        $customizedProduct = CustomizedProd::find($id);

        // Check if the record exists
        if (!$customizedProduct) {
            return Redirect::route('custom-products')->with('error', 'Customization not found.');
        }

        // Decode the views JSON data to access image file names
        $views = json_decode($customizedProduct->views, true);

        // Define the upload directory (where images are stored)
        $uploadDir = public_path('uploads/canvas_images');

        // Iterate through the views to delete associated images
        foreach ($views as $section => $data) {
            if (isset($data['image'])) {
                $filePath = $uploadDir . '/' . $data['image'];

                // Check if the file exists and delete it
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }
        }

        // Delete the record from the database
        $customizedProduct->delete();

        // Return success message
        return Redirect::route('custom-products')->with('success', 'Customization deleted successfully!');
    }
}
