<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('fabric', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = $request->except(['primary_image', 'gallery_images', '_token']);

        // Handle Slug & SKU
        $data['slug'] = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->name) . '-' . Str::random(4);
        $data['sku'] = !empty($request->sku) ? $request->sku : 'HH-' . strtoupper(Str::random(6));

        // Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_new'] = $request->has('is_new');
        $data['is_bestseller'] = $request->has('is_bestseller');
        $data['status'] = $request->get('status', 'active');

        // Sizes, Lengths, Colors arrays
        $data['sizes'] = $request->sizes ? array_values((array) $request->sizes) : ['XS', 'S', 'M', 'L', 'XL'];
        $data['lengths'] = $request->lengths ? array_values((array) $request->lengths) : ['50"', '52"', '54"', '56"', '58"', '60"'];

        if ($request->filled('color_names') && is_array($request->color_names)) {
            $colors = [];
            foreach ($request->color_names as $idx => $name) {
                if (!empty($name)) {
                    $colors[] = [
                        'name' => $name,
                        'code' => $request->color_codes[$idx] ?? '#000000',
                    ];
                }
            }
            $data['colors'] = $colors;
        }

        // Primary Image Upload
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['primary_image'] = 'uploads/products/' . $filename;
        }

        // Gallery Images Upload
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = 'gal_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $gallery[] = 'uploads/products/' . $filename;
            }
            $data['gallery_images'] = $gallery;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'nullable|exists:categories,id',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data = $request->except(['primary_image', 'gallery_images', '_token', '_method']);

        $data['is_featured'] = $request->has('is_featured');
        $data['is_new'] = $request->has('is_new');
        $data['is_bestseller'] = $request->has('is_bestseller');
        $data['status'] = $request->get('status', 'active');

        // Sizes & Lengths
        $data['sizes'] = $request->sizes ? array_values((array) $request->sizes) : $product->sizes;
        $data['lengths'] = $request->lengths ? array_values((array) $request->lengths) : $product->lengths;

        if ($request->filled('color_names') && is_array($request->color_names)) {
            $colors = [];
            foreach ($request->color_names as $idx => $name) {
                if (!empty($name)) {
                    $colors[] = [
                        'name' => $name,
                        'code' => $request->color_codes[$idx] ?? '#000000',
                    ];
                }
            }
            $data['colors'] = $colors;
        }

        // Handle Primary Image
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = 'prod_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $data['primary_image'] = 'uploads/products/' . $filename;
        }

        // Handle Gallery Images
        if ($request->hasFile('gallery_images')) {
            $gallery = $product->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $filename = 'gal_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $gallery[] = 'uploads/products/' . $filename;
            }
            $data['gallery_images'] = $gallery;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        return back()->with('success', 'Featured status updated.');
    }

    public function toggleStatus(Product $product)
    {
        $newStatus = $product->status === 'active' ? 'draft' : 'active';
        $product->update(['status' => $newStatus]);
        return back()->with('success', "Product status changed to {$newStatus}.");
    }
}
