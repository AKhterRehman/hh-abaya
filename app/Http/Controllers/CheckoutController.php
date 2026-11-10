<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
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

        $isFreeShipping = $subtotal >= $freeShippingMin;
        $shippingFee = ($isFreeShipping || $subtotal == 0) ? 0 : $standardShippingFee;

        $coupon = session()->get('applied_coupon', null);
        $discount = 0;
        if ($coupon) {
            $discount = (float) $coupon['discount'];
        }

        $total = max(0, $subtotal - $discount + $shippingFee);

        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'itemsCount' => $itemsCount,
            'freeShippingMin' => $freeShippingMin,
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

        if (empty($data['cart'])) {
            return redirect()->route('shop.index')->with('info', 'Your shopping bag is empty. Please add items to checkout.');
        }

        $cities = [
            'Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 
            'Multan', 'Peshawar', 'Quetta', 'Sialkot', 'Hyderabad', 
            'Gujranwala', 'Abbottabad', 'Bahawalpur', 'Sargodha', 'Sukkur',
            'Sahiwal', 'Wah Cantt', 'Mardan', 'Kasur', 'Rahim Yar Khan', 'Other'
        ];

        return view('checkout.index', array_merge($data, ['cities' => $cities]));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->code));
        $data = $this->getCartData();
        $subtotal = $data['subtotal'];

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid discount code.',
            ], 422);
        }

        if (!$coupon->isValid($subtotal)) {
            if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                return response()->json([
                    'success' => false,
                    'message' => "Coupon requires a minimum order of PKR " . number_format($coupon->min_order_amount),
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'This coupon is expired or has reached its usage limit.',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        session()->put('applied_coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'min_order_amount' => $coupon->min_order_amount,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Coupon '{$coupon->code}' applied successfully! Saved PKR " . number_format($discount),
            'discount' => $discount,
            'subtotal' => $subtotal,
            'total' => max(0, $subtotal - $discount + $data['shippingFee']),
        ]);
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }

    public function process(Request $request)
    {
        $data = $this->getCartData();

        if (empty($data['cart'])) {
            return redirect()->route('shop.index')->with('error', 'Your shopping bag is empty.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email|max:100',
            'shipping_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'payment_method' => 'required|in:cod,bank_transfer,card',
            'order_notes' => 'nullable|string|max:500',
        ]);

        return DB::transaction(function () use ($request, $data) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'province' => $request->province ?? 'Pakistan',
                'postal_code' => $request->postal_code,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'card' ? 'paid' : 'pending',
                'order_status' => 'pending',
                'subtotal' => $data['subtotal'],
                'shipping_fee' => $data['shippingFee'],
                'discount' => $data['discount'],
                'coupon_code' => $data['coupon']['code'] ?? null,
                'total' => $data['total'],
                'order_notes' => $request->order_notes,
            ]);

            foreach ($data['cart'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'product_image' => $item['image'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'size' => $item['size'],
                    'length' => $item['length'],
                    'color' => $item['color'],
                    'total' => $item['price'] * $item['quantity'],
                ]);

                // Reduce inventory
                $product = Product::find($item['product_id']);
                if ($product && $product->stock > 0) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Increment coupon usage
            if (!empty($data['coupon']['id'])) {
                $coupon = Coupon::find($data['coupon']['id']);
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // Clear session cart & coupon
            session()->forget('cart');
            session()->forget('applied_coupon');

            return redirect()->route('checkout.success', $order->order_number);
        });
    }

    public function success(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items.product')->firstOrFail();

        // Format WhatsApp message
        $storeWhatsApp = Setting::get('store_whatsapp', '923001234567');
        $msg = "Salaam H&H Abaya Collection! I have placed an order.\n\n" .
               "Order #: {$order->order_number}\n" .
               "Name: {$order->customer_name}\n" .
               "Total: PKR " . number_format($order->total) . "\n" .
               "Payment: " . strtoupper($order->payment_method) . "\n\n" .
               "Please confirm my order. JazakAllah Khair!";
        $whatsappUrl = "https://wa.me/{$storeWhatsApp}?text=" . urlencode($msg);

        $bankDetails = [
            'name' => Setting::get('bank_name', 'Meezan Bank Ltd'),
            'title' => Setting::get('bank_account_title', 'H&H Abaya Collection'),
            'number' => Setting::get('bank_account_number', '0101-0103456789'),
            'iban' => Setting::get('bank_iban', 'PK64MEZN0001010103456789'),
        ];

        return view('checkout.success', compact('order', 'whatsappUrl', 'bankDetails'));
    }
}
