<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class changeStatus extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
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
}
