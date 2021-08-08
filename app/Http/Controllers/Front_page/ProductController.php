<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $exist_category = '';
        $categories = Category::get();
        $products = Product::paginate(12);
        $top_products = Product::inRandomOrder()->limit(8)->get();
        $latest_products = Product::orderBy('created_at', 'DESC')->inRandomOrder()->limit(8)->get();
        return view('front_page.product', compact('products', 'top_products', 'latest_products', 'categories', 'exist_category'));
    }

    public function category($category_id)
    {
        $categories = Category::get();
        $products = Product::where('category_id', $category_id)->paginate(12);
        $exist_category = Product::where('category_id', $category_id)->first();
        return view('front_page.product', compact('products', 'categories', 'exist_category'));
    }
}
