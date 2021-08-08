<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function index($id)
    {
        $products = Product::find($id);
        $related_products = Product::where('category_id', $products->category_id)->inRandomOrder()->limit(5)->get();
        $date = Carbon::now();
        return view('front_page.detail-product', compact('products', 'related_products', 'date'));
    }
}
