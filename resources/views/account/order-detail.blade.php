@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' | H&H Abaya Collection')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-6">
    
    <div class="flex items-center justify-between pb-4 border-b border-stone-200">
        <div>
            <a href="{{ route('account.dashboard') }}" class="text-xs text-[#8C6D68] hover:underline font-semibold flex items-center gap-1 mb-1">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="font-mono text-2xl font-bold text-stone-900">{{ $order->order_number }}</h1>
            <span class="text-xs text-stone-500">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</span>
        </div>

        <div class="text-right space-y-1">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->status_badge_class }} border inline-block">
                {{ $order->order_status }}
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $order->payment_badge_class }} border block text-center">
                Payment: {{ $order->payment_status }}
            </span>
        </div>
    </div>

    @if($order->tracking_number)
        <div class="p-4 rounded-xl bg-indigo-50 border border-indigo-200 flex items-center justify-between text-xs">
            <div>
                <span class="font-bold text-indigo-900 block">Courier: {{ $order->courier_name ?? 'Courier Service' }}</span>
                <span class="text-indigo-700 font-mono">Tracking #: {{ $order->tracking_number }}</span>
            </div>
            <a href="{{ route('tracking.index', ['order_number' => $order->order_number]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                Track Live
            </a>
        </div>
    @endif

    <!-- Items List -->
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
        <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-200">
            Order Items
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
                <span>Shipping Fee:</span>
                <span>{{ $order->shipping_fee == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_fee) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="flex justify-between text-emerald-700 font-semibold">
                    <span>Discount ({{ $order->coupon_code }}):</span>
                    <span>-PKR {{ number_format($order->discount) }}</span>
                </div>
            @endif
            <div class="flex justify-between text-sm font-bold text-stone-900 pt-2 border-t border-stone-200">
                <span>Total Amount:</span>
                <span class="text-[#8C6D68]">PKR {{ number_format($order->total) }}</span>
            </div>
        </div>
    </div>

    <!-- Destination Address -->
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm text-xs space-y-2">
        <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-200">
            Delivery Destination
        </h3>
        <p class="text-stone-800 font-bold">{{ $order->customer_name }}</p>
        <p class="text-stone-600">{{ $order->shipping_address }}</p>
        <p class="text-stone-600">{{ $order->city }}, {{ $order->province }}</p>
        <p class="text-stone-600 font-mono">{{ $order->customer_phone }}</p>
        @if($order->order_notes)
            <p class="text-stone-500 italic mt-2">Notes: "{{ $order->order_notes }}"</p>
        @endif
    </div>

</div>

@endsection
