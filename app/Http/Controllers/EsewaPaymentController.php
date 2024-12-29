<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Orders;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xentixar\EsewaSdk\Esewa;

class EsewaPaymentController extends Controller
{
    public function pay(Request $request)
    {
        $transactionUuid = uniqid('txn_' . microtime(true) . '_', true);
        $carts = cart::with('products')->where('user_id', '=', Auth::id())->get();
        $sum = 0;

        foreach ($carts as $cart) {
            // Check if the cart has a regular product (not customized)
            if ($cart->product_id) {
                // Assuming `product_id` is not null, fetch the related product
                if ($cart->products) {
                    // dd($cart->products->price); // Display the price of the product
                    // Sum calculation example:
                    $sum += $cart->quantity * $cart->products->price;
                }
            } else if ($cart->customProd_id) {
                if ($cart->customizedProducts) {
                    // dd($cart->customizedProducts->products->price);
                    $sum += ($cart->quantity * $cart->customizedProducts->products->price) + $cart->customizedProducts->customization_charge;
                }
            }
            // If neither product nor customized product is present
            else {
                echo "No product or customization found for cart ID: " . $cart->id;
            }
        }

        // After looping, proceed with eSewa or other payment logic
        if ($sum > 0) {
            $esewa = new Esewa();
            $esewa->config(route('esewa.check'), route('esewa.check'), $sum, $transactionUuid);
            $esewa->init();
        }
    }

    public function check(Request $request)
    {
        $esewa = new Esewa();
        $data =  $esewa->decode();
        if ($data) {
            if ($data["status"] === 'COMPLETE') {
                $carts = Cart::query()->where('user_id', '=', Auth::id())->get();
                $msg = 'Payment succesful';
                foreach ($carts as $cart) {
                    Orders::query()->create([
                        'user_id' => Auth::id(),
                        'product_id' => $cart->product_id,
                        'customProd_id' => $cart->customProd_id, // Include custom product ID if applicable
                        'quantity' => $cart->quantity,
                        'esewa_status' => 'Paid',
                        'price_per_item' => $cart->customProd_id
                            ? $cart->customizedProducts->products->price + $cart->customizedProducts->customization_charge // Add customization charge if applicable
                            : $cart->products->price,
                        'total_amount' => $data['total_amount'],
                        'product_status' => 'ordered',
                    ]);

                    Payments::query()->create([
                        'user_id' => Auth::id(),
                        'transaction_code' => $data['transaction_code'],
                        'amount' => $cart->customProd_id
                            ? $cart->customizedProducts->products->price + $cart->customizedProducts->customization_charge // Add customization charge if applicable
                            : $cart->products->price,
                        'quantity' => $cart->quantity,
                        'product_id' => $cart->product_id,
                        'customProd_id' => $cart->customProd_id, // Include custom product ID if applicable
                    ]);

                    $cart->delete(); // Remove cart item after processing
                }
                $id = Auth::user()->id;

                $transaction_code = $data['transaction_code'];
                $datas = Payments::query()->where('transaction_code', '=', $transaction_code)->paginate(15);
                $totalAmount = Payments::query()
                    ->where('transaction_code', '=', $transaction_code)
                    ->sum('amount');
                return view('frontend.payment-success', compact('datas', 'totalAmount'));
            }
        }
        return redirect()->route('payment-failed')->with('success', 'Ordered failed');
    }
}
