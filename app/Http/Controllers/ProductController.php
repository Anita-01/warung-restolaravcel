<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Support\Htmlable;

class ProductController extends Controller
{


    public function index()
    {
        $products = Product::latest()->paginate(10);

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'qty' => $request->qty,
            'price' => $request->price,
            'image' => $imagePath
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::findOrFail($request->id);

        $data = [
            'name' => $request->name,
            'category_id' => $request->category_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ];


        if ($request->hasFile('image')) {


            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }


            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Data product berhasil diupdate');
    }
    public function search(Request $request)
    {
        $key = $request->key;

        $query = Product::with('category')
            ->latest();

        if ($key) {
            $query->where('name', 'like', '%' . $key . '%');
        }

        $products = $query->paginate(10);

        return response()->json([
            'data' => $products->items(),
            'from' => $products->firstItem(),
            'to' => $products->lastItem(),
            'total' => $products->total(),
            'links' => $products->links()->render()
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

    public function totalPrice(Request $request)
    {
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