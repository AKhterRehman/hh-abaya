@extends('layouts.app')

@section('title', 'Order Confirmed - ' . $order->order_number . ' | H&H Abaya')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <div class="bg-white rounded-3xl border border-[#E8DDD7] p-8 sm:p-12 shadow-xl space-y-8">
        
        <!-- Header & Order ID -->
        <div class="text-center space-y-3">
            <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto ring-8 ring-emerald-50/50">
                <i class="fa-solid fa-circle-check text-4xl"></i>
            </div>
            <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Order Confirmed</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900">
                JazakAllah Khair, {{ $order->customer_name }}!
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 max-w-md mx-auto">
                Your order has been received and is being prepared with utmost care. A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>.
            </p>

            <div class="inline-block px-5 py-2.5 bg-[#FAF7F2] rounded-xl border border-[#C5A059]/40 mt-2">
                <span class="text-xs text-stone-500 mr-2">Your Order Reference:</span>
                <strong class="font-mono text-base text-[#231F20] font-bold">{{ $order->order_number }}</strong>
            </div>
        </div>

        <!-- WhatsApp Quick Confirm Banner -->
        <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-emerald-950">Confirm Order via WhatsApp</h4>
                    <p class="text-[11px] text-emerald-800">Send your order number to our concierge for priority dispatch and live updates.</p>
                </div>
            </div>
            <a href="{{ $whatsappUrl }}" 
               target="_blank" 
               class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow flex items-center gap-2 whitespace-nowrap">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Send to WhatsApp</span>
            </a>
        </div>

        <!-- Bank Transfer Details (If Applicable) -->
        @if($order->payment_method === 'bank_transfer')
            <div class="p-6 rounded-2xl bg-amber-50/70 border border-amber-200 space-y-3">
                <div class="flex items-center gap-2 text-amber-900 font-bold text-sm">
                    <i class="fa-solid fa-building-columns text-[#C5A059]"></i>
                    <span>Bank Transfer Instructions (Meezan Bank)</span>
                </div>
                <p class="text-xs text-amber-950">
                    Please transfer the total amount of <strong class="text-[#8C6D68]">PKR {{ number_format($order->total) }}</strong> to the following account and send the screenshot via WhatsApp.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-white p-4 rounded-xl border border-amber-200/80">
                    <div>
                        <span class="text-stone-400 block text-[10px]">Bank Name:</span>
                        <strong class="text-stone-800">{{ $bankDetails['name'] }}</strong>
                    </div>
                    <div>
                        <span class="text-stone-400 block text-[10px]">Account Title:</span>
                        <strong class="text-stone-800">{{ $bankDetails['title'] }}</strong>
                    </div>
                    <div>
                        <span class="text-stone-400 block text-[10px]">Account Number:</span>
                        <strong class="text-stone-800 font-mono">{{ $bankDetails['number'] }}</strong>
                    </div>
                    <div>
                        <span class="text-stone-400 block text-[10px]">IBAN:</span>
                        <strong class="text-stone-800 font-mono">{{ $bankDetails['iban'] }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <!-- Order Items Breakdown -->
        <div class="space-y-4">
            <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-200">
                Purchased Items
            </h3>

            <div class="divide-y divide-stone-100">
                @foreach($order->items as $item)
                    <div class="py-3 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-14 h-16 rounded-lg overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200">
                                <img src="{{ $item->product_image ? (str_starts_with($item->product_image, 'http') ? $item->product_image : asset($item->product_image)) : asset('images/logo.jpg') }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-stone-900">{{ $item->product_name }}</h4>
                                <p class="text-[11px] text-stone-500">Size: {{ $item->size }} | Length: {{ $item->length }} | {{ $item->color }}</p>
                                <span class="text-[11px] text-stone-400">Qty: {{ $item->quantity }} × PKR {{ number_format($item->price) }}</span>
                            </div>
                        </div>
                        <span class="font-bold text-stone-900">PKR {{ number_format($item->total) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-stone-200 space-y-1.5 text-xs text-stone-600">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span>PKR {{ number_format($order->subtotal) }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Delivery Fee:</span>
                    <span>{{ $order->shipping_fee == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_fee) }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-emerald-700 font-semibold">
                        <span>Discount ({{ $order->coupon_code }}):</span>
                        <span>-PKR {{ number_format($order->discount) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-bold text-stone-900 pt-2 border-t border-stone-200">
                    <span>Total Amount:</span>
                    <span class="text-[#8C6D68]">PKR {{ number_format($order->total) }}</span>
                </div>
            </div>
        </div>

        <!-- Delivery & Payment Information -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 rounded-2xl bg-[#FAF7F2] border border-[#E8DDD7] text-xs">
            <div>
                <h4 class="font-bold text-stone-900 mb-1">Delivery Destination:</h4>
                <p class="text-stone-600">{{ $order->customer_name }}</p>
                <p class="text-stone-600">{{ $order->shipping_address }}</p>
                <p class="text-stone-600">{{ $order->city }}, {{ $order->province }}</p>
                <p class="text-stone-600 font-mono mt-1">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <h4 class="font-bold text-stone-900 mb-1">Payment & Dispatch:</h4>
                <p class="text-stone-600">Payment: <strong>{{ $order->payment_method_label }}</strong></p>
                <p class="text-stone-600">Status: <strong class="uppercase text-amber-700">{{ $order->order_status }}</strong></p>
                <p class="text-stone-500 mt-2">Estimated Arrival: <strong>3 to 5 business days</strong></p>
            </div>
        </div>

        <!-- Action Links -->
        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('tracking.index') }}" class="px-7 py-3 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                <i class="fa-solid fa-truck-fast mr-2"></i> Track Your Order Status
            </a>
            <a href="{{ route('shop.index') }}" class="px-7 py-3 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold uppercase tracking-wider rounded-xl transition">
                Continue Shopping
            </a>
        </div>

    </div>

</div>

@endsection
