<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $query = Wishlist::with('product.category');

        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }

        $wishlists = $query->latest()->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);
        $userId = Auth::id();
        $sessionId = session()->getId();

        $item = Wishlist::where('product_id', $product->id)
            ->where(function ($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->first();

        $added = false;
        if ($item) {
            $item->delete();
            $message = "Removed {$product->name} from your wishlist.";
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $product->id,
            ]);
            $added = true;
            $message = "Added {$product->name} to your wishlist!";
        }

        $count = Wishlist::where(function ($q) use ($userId, $sessionId) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->where('session_id', $sessionId);
            }
        })->count();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'added' => $added,
                'message' => $message,
                'count' => $count,
            ]);
        }

        return back()->with('success', $message);
    }
}
