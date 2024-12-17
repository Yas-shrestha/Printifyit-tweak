<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (Auth::user() && Auth::user()->role == "user") {
            $orders = Orders::query()->where('user_id', Auth::id())->paginate(10);
        } else {
            $orders = Orders::query()->paginate(10);
        }
        return view('backend.index', compact('orders'));
    }
}
