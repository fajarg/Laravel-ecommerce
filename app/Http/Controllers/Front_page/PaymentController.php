<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $address = $request->input('setAdress');
        $total_pay = (float)$request->input('total_price');
        $id = Auth::User()->id;

        $order = DB::table('orders')
            ->where('user_id', $id)->first();

        if ($order) {
            $order_id = $order->id;
        } else {
            $order_id = '';
        }

        $data['order_items'] = DB::table('order_items')
            ->select('products.nama', 'order_items.qty', 'products.harga', 'products.image', 'order_items.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->orderBy('order_items.id', 'DESC')
            ->where('order_items.order_id', $order_id)
            ->get();



        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-41RLxt9KyTLEuul3jcdn-XCH';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $total_pay,
            ),
            'customer_details' => array(
                'first_name' => '',
                'last_name' => Auth::User()->name,
                'email' => Auth::User()->email,
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $all = [
            'address' => $address,
            'total_pay' => $total_pay,
            'snap' => $snapToken,
        ];

        $status = \Midtrans\Transaction::status(2127618253);
        // $status = json_decode(json_encode($status), true);
        // dd($status);

        return view('front_page.payment', $data, $all);
    }
}
