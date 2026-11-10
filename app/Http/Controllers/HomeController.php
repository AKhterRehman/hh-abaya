<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();
        $categories = Category::active()->take(6)->get();
        
        $featuredProducts = Product::featured()->with('category')->take(8)->get();
        $newArrivals = Product::newArrivals()->with('category')->take(8)->get();
        $bestsellers = Product::bestsellers()->with('category')->take(8)->get();
        
        $reviews = Review::approved()
            ->with('product')
            ->latest()
            ->take(6)
            ->get();

        $umrahCollection = Product::active()
            ->whereHas('category', function ($q) {
                $q->where('slug', 'the-umrah-edit');
            })
            ->take(4)
            ->get();

        return view('home', compact(
            'banners',
            'categories',
            'featuredProducts',
            'newArrivals',
            'bestsellers',
            'reviews',
            'umrahCollection'
        ));
    }
}
