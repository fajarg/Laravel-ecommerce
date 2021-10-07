<?php

namespace App\Http\Controllers\Api;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name, $order_id)
    {
        $data = OrderItem::with('product')->where('order_id', $order_id)->get();

        return response()->json(['message' => 'List order item of : ' . $name  . ' and order_id : ' . $order_id, 'data' => $data]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $name, $order_id)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $data = $request->all();

        OrderItem::create($data);

        // update stock in product
        $product_id = $request->product_id;
        $qty = $request->qty;

        $product = Product::find($product_id);
        $stock = $product->stock;
        $sisa_stock = $stock - $qty;

        $product->stock = $sisa_stock;
        $product->save();


        $orderitem = OrderItem::with('product')->where('order_id', $data['order_id'])->get();

        return response()->json(['message' => 'Success add order item to : ' . $name  . ' and order_id : ' . $order_id, 'data' => $orderitem, 'produk' => $product, 'sisa_stock' => $sisa_stock]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $name, $order_id, $id)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer',
        ]);


        $data = OrderItem::find($id);
        $data->order_id = $request->order_id;
        $data->product_id = $request->product_id;
        $data->qty = $request->qty;

        $data->save();


        return response()->json(['message' => 'Successfully updated order item from  : ' . $name  . ' where order id : ' . $order_id . ' and id : ' . $id, 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($name, $order_id, $id)
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

        OrderItem::where('order_id', $order_id)->where('id', $id)->delete();
        $orderitem = OrderItem::with('product')->where('order_id', $order_id)->get();

        return response()->json(['message' => 'Successfully deleted order item from  : ' . $name  . ' where order id : ' . $order_id . ' and id : ' . $id, 'data' => $orderitem]);
    }

    public function search(Request $request, $name, $order_id)
    {
        $request->get('search');
        $request->get('order_id');
        $key = $request->get('search');

        if (isset($key)) {
            $data =  DB::table('order_items')
                ->select('order_items.id', 'order_items.order_id', 'order_items.product_id', 'products.nama', 'order_items.qty')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->orderBy('order_items.id', 'DESC')
                ->where('order_items.order_id', '=', $order_id)
                ->where(function ($query) use ($key) {
                    $query
                        ->where('products.nama', 'like', '%' . $key . '%')
                        ->orWhere('order_items.qty', 'like', '%' . $key . '%');
                })
                ->get();
        } else {
            $data =  DB::table('order_items')
                ->select('order_items.id', 'order_items.order_id', 'order_items.product_id', 'products.nama', 'order_items.qty')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->orderBy('order_items.id', 'DESC')
                ->where('order_items.order_id', $order_id)
                ->get();
        }

        // return response()->json(['message' => 'Search order item from : ' . $name  . ' and order_id : ' . $order_id, 'data' => $data]);
        return json_encode($data);
    }

    public function show_max($product_id)
    {
        $product = Product::where('id', $product_id)->first();

        return json_encode($product);
    }
}
