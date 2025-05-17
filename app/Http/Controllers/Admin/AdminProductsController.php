<?php

namespace App\Http\Controllers\Admin;
use App\Models\Product;

use App\Models\Category;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProductsController extends Controller
{
    public function index(Request $request) {
        $categories = Category::all();
        $productSizes = ProductSize::all();
        $query = Product::with('category');
    

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
    

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
    

        if ($request->filled('stock_status')) {
            $query->where('isActive', $request->stock_status);
        }
    

        if ($request->filled('featured')) {
            $query->where('isFeatured', $request->featured);
        }
    
        $products = $query->orderBy('created_at', 'desc')->paginate(10);
    
        if ($request->ajax()) {
            return view('admin.products.table', compact('products', 'productSizes', 'categories'))->render();
        }

        return view('admin.products.index', compact('products', 'productSizes', 'categories'));
    }

    public function create() {

        return view('admin.products.create');

    }

    public function show($id) {
        $product = Product::with('category', 'productSizes')->where('id', $id)->firstOrFail();;
        return view('admin.products.show', compact('product'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isActive' => 'required|boolean',
            'isFeatured' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
            'sizes' => 'required|array', // Expect an array of sizes
            'sizes.*.size' => 'required|string|max:255',
            'sizes.*.stock' => 'required|integer|min:0',
        ]);
    
        // Handle file uploads
        foreach (['thumbnail', 'image1', 'image2'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $validatedData[$imageField] = $request->file($imageField)->store("products_images", "public");
            }
        }
    
        // Create the product
        $product = Product::create($validatedData);
    
        // Create associated product sizes
        foreach ($request->sizes as $size) {
            ProductSize::create([
                'product_id' => $product->id,
                'size' => $size['size'],
                'stock' => $size['stock']
            ]);
        }
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $productSizes = ProductSize::where('product_id', $id)->get();
    
        if (request()->ajax()) {
            $view = view('admin.products.edit', compact('product', 'categories', 'productSizes'))->render();
            return response()->json(['html' => $view]);
        }
    
        return view('admin.products.edit', compact('product', 'categories', 'productSizes'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'isActive' => 'required|boolean',
            'isFeatured' => 'required|boolean',
            'quantity' => 'required|integer|min:0',
            'sizes' => 'required|array',
            'sizes.*.size' => 'required|string|max:255',
            'sizes.*.stock' => 'required|integer|min:0',
        ]);
    
        $product = Product::findOrFail($id);
        
        // Handle file uploads before updating the product
        foreach (['image1', 'image2'] as $imageField) {
            if ($request->hasFile($imageField)) {
                $validatedData[$imageField] = $request->file($imageField)->store("products_images", "public");
            }
        }

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')->store("products_thumbnails", "public");
        } else {
            // If no new thumbnail is uploaded, keep the old one
            $validatedData['thumbnail'] = $product->thumbnail;
        }
        
        // Now update the product with the correct image paths
        $product->update($validatedData);
    
        // Get current sizes in the database
        $existingSizes = ProductSize::where('product_id', $product->id)->pluck('size')->toArray();
        $submittedSizes = collect($request->sizes)->pluck('size')->toArray();
    
        // Delete sizes that were removed by the user
        ProductSize::where('product_id', $product->id)
            ->whereNotIn('size', $submittedSizes)
            ->delete();
    
        // Update existing sizes or add new ones
        foreach ($request->sizes as $size) {
            ProductSize::updateOrCreate(
                ['product_id' => $product->id, 'size' => $size['size']],
                ['stock' => $size['stock']]
            );
        }
    
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // This sets the 'deleted_at' timestamp

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}