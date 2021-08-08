<?php

namespace App\Http\Controllers\Front_page;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $id_user = Auth::User()->id;
            $cek = DB::table('orders')
                ->where('user_id', $id_user)->first();
        }

        if (Auth::check() && $cek) {
            $user_id = Auth::User()->id;

            $order = DB::table('orders')
                ->where('user_id', $user_id)->first();

            $data['order_items'] = DB::table('order_items')
                ->select('products.nama', 'order_items.qty', 'products.harga', 'products.image')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->orderBy('order_items.id', 'DESC')
                ->where('order_items.order_id', $order->id)
                ->get();

            $cart = $data['order_items']->all();

            session(['key' => $cart]);
        }

        $categories = Category::get();
        $top_products = Product::inRandomOrder()->limit(8)->get();
        $latest_products = Product::orderBy('created_at', 'DESC')->inRandomOrder()->limit(8)->get();
        return view('front_page.v_home', compact('top_products', 'latest_products', 'categories'));
    }
}
