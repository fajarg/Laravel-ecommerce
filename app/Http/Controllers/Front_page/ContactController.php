<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $fav_products = Product::inRandomOrder()->limit(4)->get();
        return view('front_page.contact', compact('fav_products'));
    }
}
