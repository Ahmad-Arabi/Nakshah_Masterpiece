<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoriesController extends Controller
{
    public function index(Request $request) {
        $query = Category::query(); 
    

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
    
        $categories = $query->orderBy('created_at', 'desc')->paginate(7);
    
        if ($request->ajax()) {
            return view('admin.categories.table', compact('categories'))->render();
        }
    
        return view('admin.categories.index', compact('categories'));
    }

    public function create() {

        return view('admin.categories.create');

    }

    public function store(Request $request) {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'isActive' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validatedData = $request->except('image');
        
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }

        Category::create($validatedData); // Save the category
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
   
        if (request()->ajax()) {
            // Render the edit modal view with the category data
            $view = view('admin.categories.edit', compact('category'))->render();
            return response()->json(['html' => $view]);
        }

        // Fallback: Return a full view if the request is not AJAX (optional)
        return view('admin.categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'isActive' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'image.max' => 'Image size is too big. Maximum size is 2MB.',
            'image.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif.',
            'image.image' => 'The file must be an image.',
            'image.required' => 'Image is required.',
            'name.required' => 'Name is required.',
            'address.required' => 'address is required.',
            'description.required' => 'Description is required.',
        ]);

        $validatedData = $request->except('image');

        $category = Category::findOrFail($id);
        
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }
        
        
        $category->update($validatedData);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete(); // This sets the 'deleted_at' timestamp

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }
}