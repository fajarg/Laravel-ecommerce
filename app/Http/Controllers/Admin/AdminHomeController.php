<?php


namespace App\Http\Controllers\Admin;

use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $order = DB::table('orders')->count();
        $product = DB::table('products')->count();
        $user = DB::table('users')->count();
        $order_item = DB::table('order_items')->sum('qty');
        return view('admin.dashboard.dashboard', compact('order', 'product', 'user', 'order_item'));
    }
}
