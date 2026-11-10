@extends('layouts.app')

@section('title', 'Your Shopping Bag | H&H Abaya Collection')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="text-center max-w-xl mx-auto mb-10 space-y-2">
        <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Shopping Bag</span>
        <h1 class="font-serif text-3xl font-bold text-stone-900">Review Your Selections</h1>
    </div>

    @if(count($cart) > 0)
        <!-- Free Shipping Progress -->
        <div class="max-w-3xl mx-auto mb-8 p-4 bg-white rounded-2xl border border-[#E8DDD7] shadow-sm">
            @if(!$isFreeShipping)
                <div class="flex items-center justify-between text-xs font-semibold text-stone-700 mb-1.5">
                    <span>Add <strong class="text-[#8C6D68]">PKR {{ number_format($amountNeededForFreeShipping) }}</strong> more for <span class="text-emerald-700 font-bold uppercase">Free Nationwide Shipping</span></span>
                    <span class="font-bold text-[#8C6D68]">{{ $freeShippingProgress }}%</span>
                </div>
                <div class="w-full h-2.5 bg-stone-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#C5A059] to-[#8C6D68] rounded-full" style="width: {{ $freeShippingProgress }}%"></div>
                </div>
            @else
                <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>Congratulations! You qualify for <strong>FREE Nationwide Delivery!</strong></span>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Items Table (8 cols) -->
            <div class="lg:col-span-8 bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm">
                
                <div class="divide-y divide-stone-100">
                    @foreach($cart as $key => $item)
                        <div class="py-5 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                            
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-24 rounded-xl overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="font-serif text-sm font-bold text-stone-900 hover:text-[#C5A059] transition">
                                        <a href="{{ route('shop.show', $item['slug']) }}">{{ $item['name'] }}</a>
                                    </h3>
                                    <div class="flex flex-wrap gap-2 text-[11px] text-stone-500 mt-1">
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200">Size: {{ $item['size'] }}</span>
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200">Length: {{ $item['length'] }}</span>
                                        <span class="px-2 py-0.5 bg-[#FAF7F2] rounded border border-stone-200">{{ $item['color'] }}</span>
                                    </div>
                                    <span class="text-xs font-bold text-[#8C6D68] block mt-1">
                                        PKR {{ number_format($item['price']) }} each
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between w-full sm:w-auto gap-6 sm:justify-end">
                                <!-- Stepper Form -->
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center border border-stone-300 rounded-lg overflow-hidden bg-white">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} class="px-2.5 py-1 text-stone-600 hover:bg-stone-100 text-xs disabled:opacity-30">
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                    <span class="px-3 text-xs font-bold text-stone-800">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-2.5 py-1 text-stone-600 hover:bg-stone-100 text-xs">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </form>

                                <div class="text-right min-w-[90px]">
                                    <span class="text-sm font-bold text-stone-900 block">
                                        PKR {{ number_format($item['price'] * $item['quantity']) }}
                                    </span>
                                </div>

                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $key }}">
                                    <button type="submit" class="text-stone-400 hover:text-rose-600 transition p-1" title="Remove">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-6 pt-4 border-t border-stone-100 flex items-center justify-between">
                    <a href="{{ route('shop.index') }}" class="text-xs font-semibold text-[#8C6D68] hover:text-[#C5A059] flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        <span>Continue Shopping</span>
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-stone-400 hover:text-rose-600 transition">
                            Clear Entire Bag
                        </button>
                    </form>
                </div>

            </div>

            <!-- Order Summary Sidebar (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-3 border-b border-stone-200">
                        Order Summary
                    </h3>

                    <div class="space-y-2 text-xs text-stone-600">
                        <div class="flex justify-between">
                            <span>Subtotal ({{ $itemsCount }} items)</span>
                            <span class="font-semibold text-stone-900">PKR {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="font-semibold {{ $shippingFee == 0 ? 'text-emerald-700' : 'text-stone-900' }}">
                                {{ $shippingFee == 0 ? 'FREE' : 'PKR ' . number_format($shippingFee) }}
                            </span>
                        </div>
                        @if($coupon)
                            <div class="flex justify-between text-emerald-700 font-semibold">
                                <span>Discount ({{ $coupon['code'] }})</span>
                                <span>-PKR {{ number_format($discount) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-sm font-bold text-stone-900 pt-3 border-t border-stone-200">
                            <span>Total</span>
                            <span class="text-[#8C6D68]">PKR {{ number_format($total) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="w-full py-4 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-lg flex items-center justify-center gap-2 block text-center">
                        <span>Proceed to Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>

                    <div class="p-3 bg-[#FAF7F2] rounded-xl border border-[#E8DDD7] text-[11px] text-stone-500 space-y-1">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-truck text-[#C5A059]"></i>
                            <span>Nationwide Delivery in 3-5 working days</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-hand-holding-dollar text-[#C5A059]"></i>
                            <span>Cash on Delivery & Bank Transfer accepted</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-[#E8DDD7] p-8 max-w-lg mx-auto space-y-4">
            <div class="w-20 h-20 rounded-full bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center mx-auto ring-1 ring-[#E8DDD7]">
                <i class="fa-solid fa-bag-shopping text-3xl"></i>
            </div>
            <h2 class="font-serif text-2xl font-bold text-stone-900">Your bag is currently empty</h2>
            <p class="text-xs text-stone-500">
                You haven't added any abayas or khimars to your shopping bag yet. Explore our handcrafted modest collection.
            </p>
            <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow">
                Explore Abayas
            </a>
        </div>
    @endif

</div>

@endsection
