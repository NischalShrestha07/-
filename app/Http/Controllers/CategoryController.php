<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with search and pagination.
     */
    public function index(Request $request)
    {
        $query = Category::with('parent');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        }

        $categories = $query->paginate(10)->appends($request->query());

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $categories = Category::all(); // For parent selection
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Auto-generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // Prevent self-parenting or cycles (basic check)
        if ($validated['parent_id'] ?? null) {
            // More advanced cycle detection can be added if needed
            if ($validated['parent_id'] == auth()->id()) { // Placeholder; adjust if needed
                return back()->withErrors(['parent_id' => 'Invalid parent selection.']);
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)
            ->whereDoesntHave('parent', function ($query) use ($category) {
                $query->where('id', $category->id); // Avoid cycles
            })
            ->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $category->id . '|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prevent self-parenting or cycles
        if ($validated['parent_id'] ?? null) {
            if ($validated['parent_id'] == $category->id) {
                return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
            }
            // Check for cycle: if parent is a descendant
            $parent = Category::find($validated['parent_id']);
            while ($parent) {
                if ($parent->id == $category->id) {
                    return back()->withErrors(['parent_id' => 'This would create a category cycle.']);
                }
                $parent = $parent->parent;
            }
        }

        // Handle image update
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        // Prevent deletion if has children or products (add checks if needed)
        if ($category->children()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete category with subcategories.']);
        }

        // Assuming products relation exists; uncomment if implemented
        // if ($category->products()->count() > 0) {
        //     return back()->withErrors(['error' => 'Cannot delete category with associated products.']);
        // }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
