<?php

namespace App\Http\Controllers;

use App\Models\customizedProd;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role != 'user') {
            $orders = Orders::query()->paginate(5);
        } else {
            $orders = Orders::query()->where('user_id', Auth::id())->paginate(5);
        }
        return view('backend.Orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Orders::query()->find($id);

        if ($order) {
            if (!empty($order->product_id)) {
                // If found in Orders and has a product_id, return the Order view
                return view('backend.orders.view', compact('order'));
            }
        }

        // If not found in Orders or has no product_id, check in CustomizedProduct
        $order = Orders::query()
            ->where('id', $id)
            ->first();

        if ($order) {
            // Decode canvas data if necessary
            $canvasData = json_decode($order->customizedProducts->views ?? '{}', true);

            // If found in Order, return the Order view
            return view('backend.orders.custom-view', compact('order', 'canvasData'));
        }

        // If neither Orders nor CustomizedProduct records exist, redirect to index
        return redirect()->route('orders.index')->with('error', 'Order not found.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_status' => 'required|string',
        ]);

        $Order = Orders::query()->where('id', $id)->first();
        // Update the status
        $Order->product_status = $request->product_status;
        $Order->save();

        return redirect()->back()->with('msg', 'succesfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
