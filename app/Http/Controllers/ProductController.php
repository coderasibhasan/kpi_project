<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index' , compact('products'));
    }

    public function create()
    {
        return view('backend.product.create');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        if(!empty($request->image)){
            $file_name = 'products/' . time() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->put($file_name, file_get_contents($request->image));
            $product->image = $file_name;
        }
        $product->save();
        session()->flash('success', 'Product created successfully');
        return redirect()->back();
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return view('backend.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        if(!empty($request->image)){
            $file_name = 'products/' . time() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->put($file_name, file_get_contents($request->image));
            $product->image = $file_name;
        }
        $product->save();
        session()->flash('success', 'Product updated successfully');
        return redirect()->route('product.index');
    }

    public function deleteproduct($id)
    {
        $products=Product::find($id);
        $products->delete();
        return redirect()->route('product.index');
    }
}
