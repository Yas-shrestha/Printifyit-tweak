<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\cart;
use Illuminate\Http\Request;

class CartUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $cart = cart::query()->findOrFail($id);
        if ($request->quantity && (int)$request->quantity > 0) {
            $cart->update(['quantity' => $request->quantity]);
            return response()->json(['success' => 'Updated successfully'], 200);
        } else {
            return response()->json(['success' => 'Invalid quantity'], 403);
        }
    }
}
