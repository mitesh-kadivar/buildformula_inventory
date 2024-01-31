<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|unique:products',
            'price'       => 'required|numeric',
            'image'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = "default.png";
        }

        $product              = new Product();
        $product->category_id = $request->category_id;
        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->image       = $imageName;
        if ($product->save()) {
            return redirect()->route('products.index')->with('success','Product created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product    = Product::find($id);
        $categories = Category::all();
        return view('products.create', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|unique:products,name,'.$id,
            'price'       => 'required|numeric',
            'image'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::find($id);
        $imageName = $product->image;
        if($request->hasFile('image')) {
            if ($product->image != 'default.png') {
                unlink(public_path('images/') . $product->image);
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
        }

        $product->category_id = $request->category_id;
        $product->name        = $request->name;
        $product->price       = $request->price;
        $product->image       = $imageName;
        if ($product->save()) {
            return redirect()->route('products.index')->with('success','Product updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // unlink profile image
        if ($product->image != 'default.png') {
            unlink(public_path('images/') . $product->image);
        }
        if ($product->delete()){
            return redirect()->route('products.index')->with('success','Product deleted successfully.');
        }
    }
}
