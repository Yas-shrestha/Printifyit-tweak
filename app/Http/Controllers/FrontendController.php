<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\cart;
use App\Models\contact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class FrontendController extends Controller
{

    public function index()
    {
        // $products = Product::query()->where('img', '!=', '')->where('price', '!=', '')->get()->all();
        // $newProducts = Product::query()
        //     ->where('img', '!=', '')
        //     ->where('price', '!=', '')
        //     ->whereBetween('updated_at', [Carbon::now()->subDays(10), Carbon::now()])
        //     ->get();
        $carousels = Carousel::query()->limit(6)->get();


        return view('frontend.index', compact('carousels'));
    }
    public function shop()
    {
        $products = Product::query()->paginate(16);
        return view('frontend.shop', compact('products'));
    }
    public function cart()
    {
        $user_id = Auth::user()->id;
        $carts = cart::query()->where('user_id', $user_id)->get()->all();
        return view('frontend.cart', compact('carts'));
    }
    public function checkout()
    {
        return view('frontend.checkout');
    }
    public function contact()
    {
        return view('frontend.contact');
    }
    public function product()
    {
        return view('frontend.product');
    }
    public function customizeProd($id)
    {
        $product = Product::query()->where('id', $id)->get()->first();
        return view('frontend.customProd', compact('product'));
    }
    public function contactStore(Request $request)
    {
        $contact = new contact;
        $validate_data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'email|required',
            'message' => 'required',
        ]);
        $contact->name = $validate_data['name'];
        $contact->email = $validate_data['email'];
        $contact->message = $validate_data['message'];
        $contact->save();
        return redirect()->back()->with('success', 'Your queries have been submitted');
    }
    public function prodDetail($id)
    {
        $product = Product::query()->where('id', $id)->get()->first();
        return view('frontend.single-product', compact('product'));
    }
    public function paymentFailed($id)
    {
        $id = Auth::id();
        $datas = Cart::query()->where('user_id', $id)->get();
        return view('frontend.payment-failed', compact('datas'));
    }
}
