<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
   
    public function index()
    {
         $products = Product::with('category')->paginate(5); 

    return view('admin.CRUDMenu.viewmenuindex', compact('products'));
    }

  
    public function add()
    {
        $categories = Category::all();
        return view('admin.CRUDMenu.addmenu', compact('categories'));
    }

  
public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $photoPath = null;

    if($request->hasFile('photo')){

        $photoPath = $request->file('photo')
            ->store('products', 'public');
    }

    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'qty' => $request->qty,
        'price' => $request->price,
        'photo' => $photoPath
    ]);

    return redirect()
        ->route('products.index')
        ->with('success', 'Product berhasil ditambahkan');
}

  
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();

        return view('admin.CRUDMenu.editmenu', compact('product', 'categories'));
    }

public function updateProduct(Request $request)
{
    $request->validate([
        'id' => 'required',
        'name' => 'required',
        'category_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $product = Product::findOrFail($request->id);

    $data = [
        'name' => $request->name,
        'category_id' => $request->category_id,
        'qty' => $request->qty,
        'price' => $request->price,
    ];

    if ($request->hasFile('photo')) {
        $data['photo'] = $request->file('photo')->store('products', 'public');
    }

    $product->update($data);

    return redirect()
        ->route('products.index')
        ->with('success', 'Data product berhasil diupdate');
}

    public function search(Request $request)
    {
        $key = $request->key;

         $products = Product::with('category')
        ->where('name', 'like', '%' . $request->key . '%')
        ->paginate(5);

    return response()->json([
    'data' => $products->items(),
        'from' => $products->firstItem(),
        'to' => $products->lastItem(),
        'total' => $products->total(),
        'links' => (string) $products->links()

    ]);
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

  public function about()
{

    return view('user.about');
}


 public function service()
{

    return view('user.service');
}


public function show($id)
{
    $product = Product::findOrFail($id);

    return view('user.detailmenu', compact('product'));
}
    
}