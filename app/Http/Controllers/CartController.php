<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request, $id)
    {
        // dd($request);
        if (Auth::check()) {
            $product_id = $id;
            $user_id = Auth::user()->id;
            $validate_data = $request->validate([
                'quantity' => 'required|min:1',
            ]);

            // Check if the combination of user_id and product_id already exists in the cart
            $existingCartItem = cart::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($existingCartItem) {
                // If the combination exists, update the quantity
                $existingCartItem->quantity += $validate_data['quantity'];
                $existingCartItem->save();
            } else {
                // If the combination doesn't exist, create a new record
                $newCartItem = new Cart;
                $newCartItem->user_id = $user_id;
                $newCartItem->quantity = $validate_data['quantity'];
                $newCartItem->product_id = $product_id;
                $newCartItem->save();
            }

            // Redirect to the menu with a success message
            return redirect()->back()->with('success', 'Your order has been added to the cart');
        } else {
            // User is not logged in, redirect to the login page
            return redirect('login')->with('error', 'Please log in to add items to the cart');
        }
    }

    public function destroy($id)
    {
        $Cart = new Cart;
        $Cart = $Cart->where('id', $id)->First();
        $Cart->delete();
        return redirect('/cart')->with('success', 'Your data have been deleted');
    }
}
