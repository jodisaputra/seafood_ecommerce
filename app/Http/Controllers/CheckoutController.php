<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        // header('content-type: application/json');
        // echo json_encode(Auth::guard('customer')->user());
        // die;
        $carts = [];
        $total = 0;
        if(Auth::guard('customer')->check())
        {
            $carts = Cart::with(['product.gallery'])->where('customer_id', Auth::guard('customer')->user()->id)->get();
            foreach($carts as $cart)
            {
                $total += $cart['product']['price'] * $cart['qty'];
            }
        }
        // header('Content-type: application/json');
        // echo json_encode($carts);
        // die;
        if(count($carts) > 0)
        {
            return view('pages.checkout', compact('carts', 'total'));
        }
        else
        {
            Alert::toast('Tidak ada produk yang akan dibeli !', 'error');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            /**
             * algorithm create no invoice
             */
            $length = 10;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            $no_invoice = 'INV-'.Str::upper($random);

            $invoice = Invoice::create([
                'invoice_code' => $no_invoice,
                'customer_id' => $request->customer_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'full_address' => $request->full_address,
                'grand_total' => $request->grand_total,
            ]);

            $carts = Cart::where('customer_id', $request->customer_id)->with(['product'])->get();

            foreach($carts as $cart)
            {
                $invoice->orders()->create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $cart->product_id,
                    'product_name' => $cart->product->title,
                    'qty' => $cart->qty,
                    'price' => $cart->price
                ]);
            }

            // Buat transaksi ke midtrans kemudian save snap tokennya.
            $payload = [
                'transaction_details' => [
                    'order_id'      => $invoice->invoice_code,
                    'gross_amount'  => $invoice->grand_total,
                ],
                'customer_details' => [
                    'first_name'       => $invoice->name,
                    'email'            => $request->email,
                    'phone'            => $invoice->phone,
                    'shipping_address' => $invoice->full_address
                ]
            ];

            //create snap token
            $snapToken = Snap::getSnapToken($payload);
            $invoice->snap_token = $snapToken;
            $invoice->save();

            $this->response['snap_token'] = $snapToken;
        });

        return response()->json($this->response);
    }

    public function notification()
    {
        $notif = new \Midtrans\Notification();
        \DB::transaction(function () use($notif) {
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;
            $invoice = Invoice::where('invoice_code', $orderId)->first();

            if($transactionStatus == 'capture') {
                if($paymentType == 'credit_card') {
                    if($fraudStatus == 'challenge') {
                        $invoice->setStatusPending();
                    } else {
                        $invoice->setStatusSuccess();
                    }
                }
            } else if($transactionStatus == 'settlement') {
                $invoice->setStatusSuccess();
            } else if($transactionStatus == 'pending') {
                $invoice->setStatusPending();
            } else if($transactionStatus == 'deny') {
                $invoice->setStatusFailed();
            } else if ($transactionStatus == 'expire') {
                $invoice->setStatusExpired();
            } else if($transactionStatus == 'cancel') {
                $invoice->setStatusCancel();
            }
        });
        return;
    }
}
