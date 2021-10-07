<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOrderItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($nameUser, $id)
    {
        $data['id'] = $id;
        $data['name'] = $nameUser;
        $data['products'] = DB::table('products')->get();
        $data['order_items'] =  DB::table('order_items')
            ->select('order_items.id', 'order_items.order_id', 'order_items.product_id', 'products.nama', 'order_items.qty')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->orderBy('order_items.id', 'DESC')
            ->where('order_items.order_id', $id)
            ->paginate(10);
        return view('admin/order_item/order_item', $data);
    }

    public function InsertAction(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        $qty = $request->input('qty');

        DB::table('order_items')->insert(
            [
                'order_id' => $order_id,
                'product_id' =>  $product_id,
                'qty' =>  $qty,
            ]
        );


        return back()->with('status', 'Success add order item');
    }

    public function edit($name, $order_id, $id)
    {
        $data['name'] = $name;
        $data['order_id'] = $order_id;
        $data['id'] = $id;

        $data['products'] = DB::table('products')->get();
        $data['order_items'] =  DB::table('order_items')
            ->select('order_items.id', 'order_items.order_id', 'order_items.product_id', 'products.nama', 'order_items.qty', 'products.stock')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.id', $id)
            ->first();

        return view('admin/order_item/edit', $data);
    }

    public function editAction(Request $request, $name, $id)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $order_item = OrderItem::find($id);
        $old_qty = $order_item->qty;

        $order_id = $request->input('order_id');
        $product_id = $request->input('product_id');
        $req_qty = $request->input('qty');

        $product = Product::find($product_id);
        $product_stock = $product->stock;

        // kondisi untuk up di stock product 
        if ($old_qty < $req_qty) {
            $perubahan = $req_qty - $old_qty;
            $stock = $product_stock - $perubahan;

            $product->stock = $stock;
            $product->save();
        } else if ($old_qty > $req_qty) {
            $perubahan = $old_qty - $req_qty;
            $stock = $product_stock + $perubahan;

            $product->stock = $stock;
            $product->save();
        }


        DB::table('order_items')->where('id', $id)
            ->update([
                'order_id' => $order_id,
                'product_id' =>  $product_id,
                'qty' =>  $req_qty,
            ]);

        return redirect('admin/order_item/' . $name . '/' . $order_id)->with('status', 'Data was updated');
    }

    public function delete($name, $order_id, $id)
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

        return redirect('admin/order_item/' . $name . '/' . $order_id)->with('status', 'Data was deleted');
    }
}
