<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $orderNumber = trim($request->order_number);
        $phone = trim((string) $request->phone);

        $query = Order::where('order_number', $orderNumber)->with('items.product');

        if ($phone) {
            $query->where(function ($q) use ($phone) {
                $q->where('customer_phone', 'like', "%{$phone}%");
            });
        }

        $order = $query->first();

        if (!$order) {
            return back()->withInput()->with('error', 'No order found with the provided details. Please check your Order # and try again.');
        }

        return view('tracking.index', compact('order'));
    }
}
