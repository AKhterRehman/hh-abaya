@extends('layouts.admin')

@section('title', 'Manage Order ' . $order->order_number)
@section('header_title', 'Order Management: ' . $order->order_number)

@section('content')

<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-stone-200 gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-xs text-stone-500 hover:text-stone-800 flex items-center gap-1 font-semibold mb-1">
                <i class="fa-solid fa-arrow-left"></i> Back to Orders List
            </a>
            <div class="flex items-center gap-3">
                <h1 class="font-mono text-2xl font-bold text-stone-900">{{ $order->order_number }}</h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status_badge_class }} border">
                    {{ $order->order_status }}
                </span>
            </div>
            <span class="text-xs text-stone-500">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold rounded-xl transition border border-stone-300 flex items-center gap-2">
                <i class="fa-solid fa-print"></i>
                <span>Print Packing Slip & Invoice</span>
            </a>
            @php
                $msg = "Assalam o Alaikum {$order->customer_name}! Regarding your H&H Abaya order #{$order->order_number}...";
                $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $order->customer_phone) . "?text=" . urlencode($msg);
            @endphp
            <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>WhatsApp Customer</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Items & Customer Details (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Items Card -->
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Ordered Abayas & Items ({{ $order->items->count() }})
                </h3>

                <div class="divide-y divide-stone-100">
                    @foreach($order->items as $item)
                        <div class="py-4 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-20 rounded-xl overflow-hidden bg-stone-100 border border-stone-200 flex-shrink-0">
                                    <img src="{{ $item->product_image ? (str_starts_with($item->product_image, 'http') ? $item->product_image : asset($item->product_image)) : asset('images/logo.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <div class="space-y-1">
                                    <h4 class="font-serif font-bold text-sm text-stone-900">{{ $item->product_name }}</h4>
                                    <div class="flex flex-wrap gap-2 text-[11px] text-stone-600">
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200">Size: <strong>{{ $item->size }}</strong></span>
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200 text-[#8C6D68]">Length: <strong>{{ $item->length }}</strong></span>
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200">Color: <strong>{{ $item->color }}</strong></span>
                                    </div>
                                    <span class="text-stone-400 block text-[11px]">
                                        Unit Price: PKR {{ number_format($item->price) }} × {{ $item->quantity }}
                                    </span>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-stone-900">
                                PKR {{ number_format($item->total) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Totals Breakdown -->
                <div class="pt-4 border-t border-stone-200 space-y-1.5 text-xs text-stone-600">
                    <div class="flex justify-between">
                        <span>Items Subtotal:</span>
                        <span>PKR {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Delivery Fee:</span>
                        <span>{{ $order->shipping_fee == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_fee) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-emerald-700 font-bold">
                            <span>Discount Voucher ({{ $order->coupon_code }}):</span>
                            <span>-PKR {{ number_format($order->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-base font-bold text-stone-900 pt-2 border-t border-stone-200">
                        <span>Total Payable:</span>
                        <span class="text-[#8C6D68]">PKR {{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Destination Address Card -->
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Shipping & Delivery Details
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="space-y-1">
                        <span class="text-stone-400 block text-[10px] uppercase font-bold tracking-wider">Client Contact</span>
                        <p class="font-bold text-stone-900 text-sm">{{ $order->customer_name }}</p>
                        <p class="text-stone-600">{{ $order->customer_email }}</p>
                        <p class="text-stone-600 font-mono font-bold">{{ $order->customer_phone }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-stone-400 block text-[10px] uppercase font-bold tracking-wider">Destination Address</span>
                        <p class="text-stone-800">{{ $order->shipping_address }}</p>
                        <p class="text-stone-800 font-semibold">{{ $order->city }}, {{ $order->province }}</p>
                        <p class="text-stone-500">Postal Code: {{ $order->postal_code ?? 'N/A' }}</p>
                    </div>
                </div>

                @if($order->order_notes)
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-xs text-amber-900">
                        <strong>Customer Instructions / Custom Length Notes:</strong>
                        <p class="mt-0.5 italic">"{{ $order->order_notes }}"</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right: Status Update Controls (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- 1. Order Status Form -->
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Update Order Status
                </h3>

                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Current Fulfillment State</label>
                        <select name="order_status" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending (New)</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing / Tailoring</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped (In Transit)</option>
                            <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered (Completed)</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- 2. Payment Status Form -->
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Payment Status
                </h3>

                <div class="text-xs text-stone-600 space-y-1">
                    <p>Method: <strong>{{ $order->payment_method_label }}</strong></p>
                    <p>Status: <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->payment_badge_class }} border">{{ $order->payment_status }}</span></p>
                </div>

                <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST" class="space-y-3 pt-2">
                    @csrf
                    <div>
                        <select name="payment_status" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 text-xs font-semibold rounded-xl transition border border-stone-300">
                        Update Payment
                    </button>
                </form>
            </div>

            <!-- 3. Assign Courier Partner & Tracking Number -->
            <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Assign Courier Tracking
                </h3>

                <form action="{{ route('admin.orders.tracking', $order->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Courier Partner</label>
                        <select name="courier_name" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="TCS Express" {{ $order->courier_name === 'TCS Express' ? 'selected' : '' }}>TCS Express</option>
                            <option value="Call Courier" {{ $order->courier_name === 'Call Courier' ? 'selected' : '' }}>Call Courier</option>
                            <option value="Leopards Courier" {{ $order->courier_name === 'Leopards Courier' ? 'selected' : '' }}>Leopards Courier</option>
                            <option value="Trax Logistics" {{ $order->courier_name === 'Trax Logistics' ? 'selected' : '' }}>Trax Logistics</option>
                            <option value="M&P Express" {{ $order->courier_name === 'M&P Express' ? 'selected' : '' }}>M&P Express</option>
                            <option value="DHL / FedEx (International)" {{ $order->courier_name === 'DHL / FedEx (International)' ? 'selected' : '' }}>DHL / FedEx (International)</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Tracking Number / Airway Bill</label>
                        <input type="text" 
                               name="tracking_number" 
                               value="{{ old('tracking_number', $order->tracking_number) }}" 
                               required 
                               placeholder="e.g. TCS-78945612" 
                               class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs font-mono uppercase focus:ring-1 focus:ring-[#C5A059]">
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                        Save Tracking & Mark Shipped
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>

@endsection
