<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Filter by Category
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search Keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('fabric', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by Price
        if ($request->filled('min_price')) {
            $query->where('regular_price', '>=', (float) $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('regular_price', '<=', (float) $request->max_price);
        }

        // Filter by Fabric
        if ($request->filled('fabric')) {
            $query->where('fabric', 'like', "%{$request->fabric}%");
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_asc':
                $query->orderBy('regular_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('regular_price', 'desc');
                break;
            case 'popular':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::active()->withCount('products')->get();
        $totalProducts = Product::active()->count();

        return view('shop.index', compact('products', 'categories', 'totalProducts'));
    }

    public function show(string $slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with(['category', 'reviews' => function ($q) {
                $q->latest();
            }])
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'relatedProducts'));
    }

    public function quickView(int $id)
    {
        $product = Product::active()->with('category')->findOrFail($id);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'category_name' => $product->category?->name ?? 'Collection',
            'regular_price' => number_format((float) $product->regular_price),
            'sale_price' => $product->sale_price ? number_format((float) $product->sale_price) : null,
            'has_discount' => $product->has_discount,
            'discount_percent' => $product->discount_percent,
            'fabric' => $product->fabric,
            'short_description' => $product->short_description,
            'primary_image' => $product->primary_image_url,
            'gallery_images' => $product->gallery_image_urls,
            'sizes' => $product->sizes ?? ['XS', 'S', 'M', 'L', 'XL'],
            'lengths' => $product->lengths ?? ['50"', '52"', '54"', '56"', '58"', '60"'],
            'colors' => $product->colors ?? [],
            'stock' => $product->stock,
            'rating' => (float) $product->rating,
            'reviews_count' => $product->reviews_count,
            'url' => route('shop.show', $product->slug),
        ]);
    }

    public function storeReview(Request $request, int $productId)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:150',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'nullable|string|max:150',
            'review_text' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'rating' => $request->rating,
            'review_title' => $request->review_title,
            'review_text' => $request->review_text,
            'is_approved' => true,
        ]);

        // Recalculate average rating & reviews count
        $avgRating = Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating');
        $count = Review::where('product_id', $product->id)->where('is_approved', true)->count();
        $product->update([
            'rating' => round($avgRating, 2),
            'reviews_count' => $count,
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted successfully.');
    }
}
