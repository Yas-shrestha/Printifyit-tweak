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
        $carts = cart::query()->where('user_id', '=', Auth::id())->get();
        $sum = 0;

        foreach ($carts as $cart) {
            $sum += $cart->quantity * $cart->product->price;
            $product_code = $cart->product->name;
        }
        if ($sum > 0) {
            $esewa = new Esewa();
            // $tax = 13* $sum/100;
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
                        'quantity' => $cart->quantity,
                        'esewa_status' => 'Payed',
                        'price_per_item' => $cart->product->price,
                        'total_amount' => $data['total_amount'],
                        'product_status' => 'ordered'
                    ]);
                    Payments::query()->create([
                        'user_id' => Auth::id(),
                        'transaction_code' => $data['transaction_code'],
                        'amount' => $cart->product->price,
                        'quantity' => $cart->quantity,
                        'product_id' => $cart->product_id,
                    ]);
                    $cart->delete();
                }
                $id = Auth::user()->id;

                $transaction_code = $data['transaction_code'];
                $datas = Payments::query()->where('transaction_code', '=', $transaction_code)->paginate(15);
                $totalAmount = Payments::query()
                    ->where('transaction_code', '=', $transaction_code)
                    ->first() // Retrieve the first matching record
                    ->total_amount;
                return view('frontend.payment-success', compact('datas', 'totalAmount'));
            }
        }
        return redirect()->route('payment-failed')->with('success', 'Ordered failed');
    }
}
