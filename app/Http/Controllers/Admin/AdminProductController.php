<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('admin.product.product', compact('products'));
    }

    public function insert()
    {
        $categories = Category::get();
        return view('admin.product.insert', compact('categories'));
    }

    public function insertAction(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:products',
            'nama' => 'required',
            'stock' => 'required|integer',
            'varian' => 'required',
            'description' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'harga' => 'required|integer',
        ]);

        $code = $request->input('code');
        $nama = $request->input('nama');
        $stock = $request->input('stock');
        $varian = $request->input('varian');
        $description = $request->input('description');
        $category_id = $request->input('category_id');
        $harga = $request->input('harga');
        $image = $request->file('image');

        if ($image) {
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('template/img/product'), $profileImage);
            $image = "$profileImage";
        }

        $product = new Product;
        $product->code = $code;
        $product->nama = $nama;
        $product->stock = $stock;
        $product->varian = $varian;
        $product->keterangan = $description;
        $product->category_id = $category_id;
        $product->harga = $harga;
        $product->image = $image;
        $product->save();

        return back()->with('status', 'Data updated!');
    }

    public function edit($id)
    {
        $categories = Category::get();
        $products = Product::find($id);
        return view('admin.product.edit', compact('categories', 'products'));
    }

    public function editAction(Request $request, $id)
    {
        $product = Product::find($id);
        $request->validate([
            'code' => 'required|unique:products,code,' . $id,
            'nama' => 'required',
            'stock' => 'required|integer',
            'varian' => 'required',
            'description' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'harga' => 'required|integer',
        ]);

        $code = $request->input('code');
        $nama = $request->input('nama');
        $stock = $request->input('stock');
        $varian = $request->input('varian');
        $description = $request->input('description');
        $category_id = $request->input('category_id');
        $harga = $request->input('harga');
        $image = $request->file('image');

        if ($image) {
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('template/img/product'), $profileImage);
            $image = "$profileImage";
        } else {
            $image = $product->image;
        }

        $product->id = $id;
        $product->code = $code;
        $product->nama = $nama;
        $product->stock = $stock;
        $product->varian = $varian;
        $product->keterangan = $description;
        $product->category_id = $category_id;
        $product->harga = $harga;
        $product->image = $image;
        $product->save();

        return back()->with('status', 'Data was updated!');
    }

    public function delete($id)
    {
        $deleteProduct = Product::find($id);
        $deleteProduct->delete();

        return back()->with('status', 'Data was deleted!');
    }
}
