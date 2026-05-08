<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
   
    // VALIDASI
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    // UPLOAD GAMBAR
    $imageName = time() . '.' . $request->image->extension();

    $request->image->move(public_path('img'), $imageName);

    // SIMPAN KE DB
    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'qty' => $request->qty,
        'price' => $request->price,
        'image' => $imageName
    ]);

    return redirect()->route('admin.products.add')
        ->with('success', 'Produk berhasil ditambahkan');
}
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
    $categories = Category::all();
        return view('admin.CRUDMenu.editmenu', compact('product', 'categories'));
    }

   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $product->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'qty' => $request->qty,
        'price' => $request->price,
    ]);

    return redirect()->route('admin.products.view')
        ->with('success', 'Produk berhasil diupdate');
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