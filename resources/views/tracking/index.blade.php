@extends('layouts.app')

@section('title', 'Track Your Order | H&H Abaya Collection')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="text-center max-w-xl mx-auto mb-10 space-y-2">
        <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Live Status</span>
        <h1 class="font-serif text-3xl font-bold text-stone-900">Track Your Order</h1>
        <p class="text-xs text-stone-500">Enter your order reference code (e.g. HH-2026-8941) to check live tailoring & courier progress.</p>
    </div>

    <!-- Tracking Form -->
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 shadow-sm max-w-2xl mx-auto mb-10">
        <form action="{{ route('tracking.track') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Order Number <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <input type="text" 
                           name="order_number" 
                           value="{{ old('order_number', request('order_number')) }}" 
                           required 
                           placeholder="e.g. HH-2026-8941" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-stone-300 text-xs uppercase font-mono tracking-wider focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
                    <i class="fa-solid fa-receipt absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400"></i>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Phone Number (Optional verification)</label>
                <div class="relative">
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="03001234567" 
                           class="w-full pl-10 pr-4 py-3 rounded-xl border border-stone-300 text-xs focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
                    <i class="fa-solid fa-phone absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Track Order</span>
            </button>
        </form>
    </div>

    <!-- Tracking Result Display (If Order Found) -->
    @if(isset($order))
        @php
            $steps = ['pending', 'processing', 'shipped', 'delivered'];
            $currentIndex = array_search($order->order_status, $steps);
            if ($currentIndex === false) $currentIndex = 0;
            if ($order->order_status === 'cancelled') $currentIndex = -1;
        @endphp

        <div class="bg-white rounded-3xl border border-[#E8DDD7] p-8 sm:p-10 shadow-lg space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-stone-200 gap-4">
                <div>
                    <span class="text-[11px] text-stone-400 uppercase tracking-widest">Order Reference</span>
                    <h2 class="font-mono text-xl font-bold text-stone-900">{{ $order->order_number }}</h2>
                    <span class="text-xs text-stone-500">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div>
                    <span class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status_badge_class }} border">
                        Status: {{ $order->order_status }}
                    </span>
                </div>
            </div>

            <!-- 4-Step Visual Progress Stepper -->
            @if($order->order_status !== 'cancelled')
                <div>
                    <div class="relative flex items-center justify-between">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-stone-200 w-full z-0"></div>
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-[#C5A059] transition-all duration-500 z-0" 
                             style="width: {{ $currentIndex * 33.33 }}%"></div>

                        <!-- Step 1: Placed -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold shadow-md {{ $currentIndex >= 0 ? 'bg-[#C5A059] text-white' : 'bg-stone-200 text-stone-500' }}">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 mt-2">Order Placed</span>
                        </div>

                        <!-- Step 2: Processing -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold shadow-md {{ $currentIndex >= 1 ? 'bg-[#C5A059] text-white' : 'bg-stone-200 text-stone-500' }}">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 mt-2">Tailoring / Packing</span>
                        </div>

                        <!-- Step 3: Shipped -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold shadow-md {{ $currentIndex >= 2 ? 'bg-[#C5A059] text-white' : 'bg-stone-200 text-stone-500' }}">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 mt-2">In Transit</span>
                        </div>

                        <!-- Step 4: Delivered -->
                        <div class="relative z-10 flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-xs font-bold shadow-md {{ $currentIndex >= 3 ? 'bg-emerald-600 text-white' : 'bg-stone-200 text-stone-500' }}">
                                <i class="fa-solid fa-house-chimney-check"></i>
                            </div>
                            <span class="text-[11px] font-bold text-stone-800 mt-2">Delivered</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                    This order was cancelled. Please contact our WhatsApp concierge if you have questions.
                </div>
            @endif

            <!-- Courier Tracking Details Card (If shipped) -->
            @if($order->tracking_number)
                <div class="p-5 rounded-2xl bg-indigo-50/80 border border-indigo-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-indigo-700 tracking-wider">Courier Dispatch Details</span>
                        <h4 class="font-serif text-sm font-bold text-indigo-950 mt-0.5">
                            {{ $order->courier_name ?? 'Courier Partner' }}
                        </h4>
                        <p class="text-xs text-stone-600 font-mono mt-0.5">
                            Tracking #: <strong>{{ $order->tracking_number }}</strong>
                        </p>
                    </div>
                    <span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold shadow">
                        Package on the Way
                    </span>
                </div>
            @endif

            <!-- Order Items -->
            <div class="space-y-3 pt-4 border-t border-stone-200">
                <h4 class="font-serif text-sm font-bold text-stone-900">Items in this Package</h4>
                <div class="divide-y divide-stone-100">
                    @foreach($order->items as $item)
                        <div class="py-3 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-14 rounded-lg overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200">
                                    <img src="{{ $item->product_image ? (str_starts_with($item->product_image, 'http') ? $item->product_image : asset($item->product_image)) : asset('images/logo.jpg') }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5 class="font-bold text-stone-900">{{ $item->product_name }}</h5>
                                    <p class="text-[11px] text-stone-500">Size: {{ $item->size }} | Length: {{ $item->length }} | {{ $item->color }}</p>
                                    <span class="text-[11px] text-stone-400">Qty: {{ $item->quantity }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-stone-900">PKR {{ number_format($item->total) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Customer Destination & Total -->
            <div class="p-5 rounded-2xl bg-[#FAF7F2] border border-[#E8DDD7] grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <h5 class="font-bold text-stone-800 mb-1">Destination Address:</h5>
                    <p class="text-stone-600">{{ $order->customer_name }}</p>
                    <p class="text-stone-600">{{ $order->shipping_address }}, {{ $order->city }}</p>
                    <p class="text-stone-500">{{ $order->customer_phone }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <h5 class="font-bold text-stone-800 mb-1">Payment:</h5>
                    <p class="text-stone-600">{{ $order->payment_method_label }}</p>
                    <p class="text-stone-600">Payment Status: <strong class="uppercase text-amber-700">{{ $order->payment_status }}</strong></p>
                    <p class="font-serif text-sm font-bold text-[#8C6D68] mt-1">Total: PKR {{ number_format($order->total) }}</p>
                </div>
            </div>

        </div>
    @endif

</div>

@endsection
