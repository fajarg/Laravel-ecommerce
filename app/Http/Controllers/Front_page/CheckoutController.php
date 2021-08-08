<?php

namespace App\Http\Controllers\Front_page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('front_page.checkout');
    }
}
