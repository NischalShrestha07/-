<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products with advanced search and filters.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        // Advanced search and filters
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('brand', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('stock_status')) {
            $query->where('stock_status', $request->stock_status);
        }

        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        if ($request->filled('price_min')) {
            $query->where('regular_price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('regular_price', '<=', $request->price_max);
        }

        $products = $query->paginate(10)->appends($request->query());
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $tags = Tag::all();
        return view('admin.products.create', compact('categories', 'brands', 'tags'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sku' => 'required|string|unique:products,sku|max:50',
            'quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'nullable|integer|min:0',
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Create product
        $product = Product::create($validated);

        // Attach tags
        if (!empty($validated['tags'])) {
            $product->tags()->attach($validated['tags']);
        }

        // Handle gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        // Handle variants
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $variantData['size'] ?? null,
                    'color' => $variantData['color'] ?? null,
                    'price' => $variantData['price'] ?? $product->regular_price,
                    'quantity' => $variantData['quantity'] ?? $product->quantity,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $tags = Tag::all();
        $galleryImages = $product->images()->get();
        $variants = $product->variants()->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'tags', 'galleryImages', 'variants'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id . '|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'nullable|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sku' => 'required|string|unique:products,sku,' . $product->id . '|max:50',
            'quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:instock,outofstock',
            'featured' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.size' => 'nullable|string|max:50',
            'variants.*.color' => 'nullable|string|max:50',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'nullable|integer|min:0',
            'deleted_variants' => 'nullable|array',
            'deleted_variants.*' => 'exists:product_variants,id',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle main image update
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Update product
        $product->update($validated);

        // Sync tags
        $product->tags()->sync($validated['tags'] ?? []);

        // Handle gallery images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        // Handle variants (create/update/delete)
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                if (isset($variantData['id'])) {
                    ProductVariant::find($variantData['id'])->update($variantData);
                } else {
                    $variantData['product_id'] = $product->id;
                    ProductVariant::create($variantData);
                }
            }
        }
        if (!empty($validated['deleted_variants'])) {
            ProductVariant::destroy($validated['deleted_variants']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete main image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        // Delete variants
        $product->variants()->delete();

        // Detach tags
        $product->tags()->detach();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk actions (e.g., delete multiple products).
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:delete',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        if ($validated['action'] === 'delete') {
            foreach ($validated['product_ids'] as $id) {
                $product = Product::find($id);
                $this->destroy($product);
            }
            return redirect()->route('admin.products.index')->with('success', 'Selected products deleted successfully.');
        }

        return back()->withErrors(['action' => 'Invalid action.']);
    }

    /**
     * Export products to CSV.
     */
    public function export()
    {
        $products = Product::with(['category', 'brand'])->get();
        $csv = fopen('php://output', 'w');
        fputcsv($csv, ['ID', 'Name', 'Slug', 'Regular Price', 'Sale Price', 'SKU', 'Category', 'Brand', 'Featured', 'Stock Status', 'Quantity']);

        foreach ($products as $product) {
            fputcsv($csv, [
                $product->id,
                $product->name,
                $product->slug,
                $product->regular_price,
                $product->sale_price,
                $product->sku,
                $product->category->name ?? '-',
                $product->brand->name ?? '-',
                $product->featured ? 'Yes' : 'No',
                $product->stock_status,
                $product->quantity,
            ]);
        }

        fclose($csv);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products.csv"',
        ];

        return response()->stream(function () use ($csv) {
            echo $csv;
        }, 200, $headers);
    }
    /**
     * Delete a gallery image.
     */
    public function destroyGalleryImage(ProductImage $image)
    {
        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();
        return back()->with('success', 'Gallery image deleted successfully.');
    }
}
