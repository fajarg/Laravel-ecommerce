<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $user_id = $request->input('user_id');
        $date = $request->input('date');

        $cek_user_id = Order::where('user_id', $user_id)->first();

        if ($cek_user_id) {
            $order_id = $cek_user_id->id;
        } else {
            $order = new Order;
            $order->user_id = $user_id;
            $order->tanggal_order = $date;
            $order->save();

            $latest_order_id = DB::table('orders')->latest('id')->first();
            $order_id = $latest_order_id->id;
        }

        $product_id = $request->input('product_id');
        $qty = $request->input('qty');

        DB::table('order_items')->insert(
            [
                'order_id' => $order_id,
                'product_id' =>  $product_id,
                'qty' =>  $qty,
            ]
        );

        // update stock in product
        $product_id = $request->product_id;

        $product = Product::find($product_id);
        $stock = $product->stock;
        $sisa_stock = $stock - $qty;

        $product->stock = $sisa_stock;
        $product->save();

        $data['order_items'] = DB::table('order_items')
            ->select('products.nama', 'order_items.qty', 'products.harga', 'products.image')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->orderBy('order_items.id', 'DESC')
            ->where('order_items.order_id', $order_id)
            ->get();

        session()->put('cart', $data);
        return redirect('/cart/' . $user_id);
    }

    public function index($id)
    {
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

        $cart = $data['order_items']->all();

        session(['key' => $cart]);

        $continue_shop = Product::orderBy('created_at', 'DESC')->inRandomOrder()->limit(4)->get();
        return view('front_page.cart', $data, compact('continue_shop'));
    }

    public function delete($id)
    {
        //add back stock to product list
        $order_item = OrderItem::find($id);

        $qty = $order_item->qty;
        $product_id = $order_item->product_id;

        $product = Product::find($product_id);
        $stock = $product->stock;
        $jumlah_stock = $stock + $qty;
        $product->stock = $jumlah_stock;
        $product->save();

        DB::table('order_items')->where('id', $id)->delete();

        return back()->with('status', 'Data was deleted!');
    }
}
