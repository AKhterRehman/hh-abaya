<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function getCartData(): array
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        $itemsCount = 0;

        foreach ($cart as $key => $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $cart[$key]['total'] = $itemTotal;
            $subtotal += $itemTotal;
            $itemsCount += $item['quantity'];
        }

        $freeShippingMin = (float) Setting::get('free_shipping_min', 5000);
        $standardShippingFee = (float) Setting::get('standard_shipping_fee', 250);

        $freeShippingProgress = $freeShippingMin > 0 ? min(100, round(($subtotal / $freeShippingMin) * 100)) : 100;
        $amountNeededForFreeShipping = max(0, $freeShippingMin - $subtotal);
        $isFreeShipping = $subtotal >= $freeShippingMin;
        $shippingFee = ($isFreeShipping || $subtotal == 0) ? 0 : $standardShippingFee;

        // Check if coupon is in session
        $coupon = session()->get('applied_coupon', null);
        $discount = 0;
        if ($coupon) {
            $discount = (float) $coupon['discount'];
            // Re-validate coupon minimum
            if ($subtotal < (float) $coupon['min_order_amount']) {
                session()->forget('applied_coupon');
                $coupon = null;
                $discount = 0;
            }
        }

        $total = max(0, $subtotal - $discount + $shippingFee);

        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'itemsCount' => $itemsCount,
            'freeShippingMin' => $freeShippingMin,
            'freeShippingProgress' => $freeShippingProgress,
            'amountNeededForFreeShipping' => $amountNeededForFreeShipping,
            'isFreeShipping' => $isFreeShipping,
            'shippingFee' => $shippingFee,
            'coupon' => $coupon,
            'discount' => $discount,
            'total' => $total,
        ];
    }

    public function index()
    {
        $data = $this->getCartData();
        return view('cart.index', $data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size' => 'nullable|string',
            'length' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = (int) ($request->quantity ?? 1);
        $size = $request->size ?? ($product->sizes[0] ?? 'Standard');
        $length = $request->length ?? ($product->lengths[0] ?? '54"');
        $color = $request->color ?? ($product->colors[0]['name'] ?? 'Original');

        $price = $product->effective_price;
        $cartKey = md5($product->id . '_' . $size . '_' . $length . '_' . $color);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                'key' => $cartKey,
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $price,
                'regular_price' => (float) $product->regular_price,
                'image' => $product->primary_image_url,
                'size' => $size,
                'length' => $length,
                'color' => $color,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Added {$product->name} to your bag!",
                'data' => $this->getCartData(),
            ]);
        }

        if ($request->has('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return back()->with('success', "Added {$product->name} to your shopping bag!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            $cart[$request->key]['quantity'] = (int) $request->quantity;
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $this->getCartData(),
            ]);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
            session()->put('cart', $cart);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from bag.',
                'data' => $this->getCartData(),
            ]);
        }

        return back()->with('success', 'Item removed from bag.');
    }

    public function drawer()
    {
        return response()->json([
            'success' => true,
            'data' => $this->getCartData(),
        ]);
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('applied_coupon');
        return back()->with('success', 'Bag cleared.');
    }
}
