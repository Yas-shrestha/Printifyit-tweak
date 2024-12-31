<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $validate_data = $request->validate([
                'quantity' => 'required',
                'size' => 'required',
                'color' => 'required',
                'product_id' => 'nullable|required_without:customProd_id', // Product ID required if customProd_id is not provided
                'customProd_id' => 'nullable|required_without:product_id', // Custom Product ID required if product_id is not provided
            ]);

            // Ensure that only one of 'product_id' or 'customProd_id' is provided
            if (empty($validate_data['product_id']) && empty($validate_data['customProd_id'])) {
                return back()->withErrors(['error' => 'Either product_id or customProd_id must be provided.']);
            }

            // Check if the combination of user_id and product_id or customProd_id already exists in the cart
            $existingCartItem = cart::where('user_id', $user_id)
                ->where(function ($query) use ($validate_data) {
                    if (!empty($validate_data['product_id'])) {
                        $query->where('product_id', $validate_data['product_id']);
                    }
                    if (!empty($validate_data['customProd_id'])) {
                        $query->where('customProd_id', $validate_data['customProd_id']);
                    }
                })
                ->first();

            if ($existingCartItem) {
                // If the combination exists, update the quantity
                $existingCartItem->quantity += $validate_data['quantity'];
                $existingCartItem->save();
            } else {
                // If the combination doesn't exist, create a new record
                $newCartItem = new cart;
                $newCartItem->user_id = $user_id;
                $newCartItem->quantity = $validate_data['quantity'];
                $newCartItem->color = $validate_data['color'];
                $newCartItem->size = $validate_data['size'];

                if (!empty($validate_data['product_id'])) {
                    $newCartItem->product_id = $validate_data['product_id'];
                }

                if (!empty($validate_data['customProd_id'])) {
                    $newCartItem->customProd_id = $validate_data['customProd_id'];
                }

                $newCartItem->save();
            }

            // Redirect to the menu with a success message
            return redirect('/shop')->with('success', 'Your order has been added to the cart');
        } else {
            // User is not logged in, redirect to the login page
            return redirect('login')->with('error', 'Please log in to add items to the cart');
        }
    }
    public function destory($id)
    {
        $Cart = new Cart;
        $Cart = $Cart->where('id', $id)->First();
        $Cart->delete();
        return redirect('admin/cart')->with('success', 'Your data have been deleted');
    }
}
