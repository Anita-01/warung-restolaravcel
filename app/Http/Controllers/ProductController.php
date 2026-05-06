<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
   
    public function index()
    {
        $products = Product::with('category')->get();

        return view('admin.CRUDMenu.viewmenuindex', compact('products'));
    }

  
    public function add()
    {
        $categories = Category::all();
        return view('admin.CRUDMenu.addmenu', compact('categories'));
    }

  
    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

  
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return view('admin.CRUDMenu.editmenu', compact('product'));
    }

    public function updateProduct(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function search(Request $request)
    {
        $key = $request->key;

        $products = Product::with('category')
            ->where('name', 'like', '%' . $request->key . '%')
            ->get();

        return response()->json($products);
    }

    
    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function totalPrice(Request $request){
        $total = $request->total_price;
    }


    public function viewMenu()
{
    $products = Product::with('category')->get();

    return view('user.menu', compact('products'));
}
    
}