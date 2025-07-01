<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::with('category')->orderBy('id', 'desc')->get();
        return view('admin.product.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('images/products', 'public');
        } else {
            $gambar = null;
        }

            $product = new Product();
            $product->nama = $request->nama;
            $product->slug = Str::slug($request->nama);
            $product->deskripsi = $request->deskripsi;
            $product->harga = $request->harga;
            $product->stok = $request->stok;
            $product->category_id = $request->category_id;
            $product->gambar = $gambar;
            $product->save();
           return redirect()->route('admin.product.index')->with('success', 'Product created succesfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
         $request->validate([
            'nama' => 'required|string|max:255|unique:products,nama,'. $product->id,
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',            
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $gambarPath = $product->gambar;
        if ($request->hasFile('gambar')) {
            if($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $gambarPath = $request->file('gambar')->store('products', 'public');
        }
            $product->nama = $request->nama;
            $product->slug = Str::slug($request->nama);
            $product->deskripsi = $request->deskripsi;
            $product->harga = $request->harga;
            $product->stok = $request->stok;
            $product->category_id = $request->category_id;
            $product->gambar = $gambarPath;
            $product->save();
           return redirect()->route('admin.product.index')->with('success', 'Product edit succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();

         return redirect()->route('admin.product.index')->with('success', 'Product delete succesfully');
    }
}
