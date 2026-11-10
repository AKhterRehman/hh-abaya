@extends('layouts.app')

@section('title', 'Express Checkout | H&H Abaya Collection')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" 
     x-data="{
         paymentMethod: 'cod',
         couponCode: '{{ $coupon['code'] ?? '' }}',
         couponApplied: {{ $coupon ? 'true' : 'false' }},
         couponDiscount: {{ $discount }},
         couponMsg: '{{ $coupon ? "Coupon " . $coupon['code'] . " applied" : "" }}',
         subtotal: {{ $subtotal }},
         shippingFee: {{ $shippingFee }},
         isSubmitting: false,

         applyCouponAjax() {
             if (!this.couponCode.trim()) return;
             const token = document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content');
             fetch('{{ route(\"checkout.apply-coupon\") }}', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                     'X-CSRF-TOKEN': token,
                     'X-Requested-With': 'XMLHttpRequest',
                     'Accept': 'application/json'
                 },
                 body: JSON.stringify({ code: this.couponCode })
             })
             .then(res => res.json().then(data => ({ status: res.status, body: data })))
             .then(res => {
                 if (res.status === 200 && res.body.success) {
                     this.couponApplied = true;
                     this.couponDiscount = res.body.discount;
                     this.couponMsg = res.body.message;
                 } else {
                     alert(res.body.message || 'Invalid coupon code.');
                 }
             })
             .catch(e => console.error(e));
         },

         removeCouponAjax() {
             const token = document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content');
             fetch('{{ route(\"checkout.remove-coupon\") }}', {
                 method: 'POST',
                 headers: {
                     'X-CSRF-TOKEN': token,
                     'X-Requested-With': 'XMLHttpRequest',
                     'Accept': 'application/json'
                 }
             })
             .then(res => res.json())
             .then(data => {
                 this.couponApplied = false;
                 this.couponDiscount = 0;
                 this.couponCode = '';
                 this.couponMsg = '';
             });
         }
     }">

    <div class="text-center max-w-xl mx-auto mb-8 space-y-1">
        <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Secure Checkout</span>
        <h1 class="font-serif text-3xl font-bold text-stone-900">Complete Your Order</h1>
        <p class="text-xs text-stone-500">Please provide your delivery information below.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" @submit="isSubmitting = true">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left Form (7 cols) -->
            <div class="lg:col-span-7 space-y-6">
                
                <!-- 1. Contact & Customer Info -->
                <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-stone-200">
                        <span class="w-6 h-6 rounded-full bg-[#8C6D68] text-white flex items-center justify-center text-xs font-bold">1</span>
                        <h3 class="font-serif text-base font-bold text-stone-900">Contact Information</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Full Name <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', auth()->user()?->name) }}" 
                                   required 
                                   placeholder="e.g. Ayesha Khan" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Phone / WhatsApp Number <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone', auth()->user()?->phone) }}" 
                                   required 
                                   placeholder="0300 1234567" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs">
                            <span class="text-[10px] text-stone-400">Rider will contact on this number for delivery</span>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', auth()->user()?->email) }}" 
                                   required 
                                   placeholder="ayesha@example.com" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs">
                            <span class="text-[10px] text-stone-400">Order tracking updates will be emailed</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Shipping Address -->
                <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-stone-200">
                        <span class="w-6 h-6 rounded-full bg-[#8C6D68] text-white flex items-center justify-center text-xs font-bold">2</span>
                        <h3 class="font-serif text-base font-bold text-stone-900">Delivery Address (Pakistan)</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Street Address / House / Flat # <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   name="shipping_address" 
                                   value="{{ old('shipping_address', auth()->user()?->address) }}" 
                                   required 
                                   placeholder="House 12-A, Street 4, Sector F-8/2..." 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">City <span class="text-rose-500">*</span></label>
                            <select name="city" required class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs bg-white">
                                <option value="">Select City...</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c }}" {{ old('city', auth()->user()?->city) === $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Province</label>
                            <input type="text" 
                                   name="province" 
                                   value="{{ old('province', 'Sindh') }}" 
                                   placeholder="e.g. Sindh, Punjab, KPK, Balochistan" 
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Special Delivery Instructions / Custom Length Notes (Optional)</label>
                            <textarea name="order_notes" 
                                      rows="2" 
                                      placeholder="e.g. Please alter length to 53 inches, or deliver after 2 PM..." 
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:ring-2 focus:ring-[#C5A059] text-xs"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 3. Payment Method -->
                <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 pb-3 border-b border-stone-200">
                        <span class="w-6 h-6 rounded-full bg-[#8C6D68] text-white flex items-center justify-center text-xs font-bold">3</span>
                        <h3 class="font-serif text-base font-bold text-stone-900">Select Payment Method</h3>
                    </div>

                    <div class="space-y-3">
                        
                        <!-- Option 1: Cash on Delivery -->
                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 transition cursor-pointer"
                               :class="paymentMethod === 'cod' ? 'border-[#8C6D68] bg-[#FAF7F2]' : 'border-stone-200 hover:border-stone-300'">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="mt-0.5 text-[#8C6D68] focus:ring-[#8C6D68]">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-stone-900">Cash on Delivery (COD)</span>
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">Most Popular</span>
                                </div>
                                <p class="text-[11px] text-stone-500 mt-0.5">Pay in cash when rider delivers your package at your doorstep.</p>
                            </div>
                        </label>

                        <!-- Option 2: Direct Bank Wire Transfer -->
                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 transition cursor-pointer"
                               :class="paymentMethod === 'bank_transfer' ? 'border-[#8C6D68] bg-[#FAF7F2]' : 'border-stone-200 hover:border-stone-300'">
                            <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="mt-0.5 text-[#8C6D68] focus:ring-[#8C6D68]">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-stone-900">Direct Bank Transfer (Meezan Bank)</span>
                                    <i class="fa-solid fa-building-columns text-stone-400"></i>
                                </div>
                                <p class="text-[11px] text-stone-500 mt-0.5">Transfer via online banking / mobile app. Account details will be shown on next screen.</p>
                            </div>
                        </label>

                        <!-- Option 3: Credit/Debit Card -->
                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 transition cursor-pointer"
                               :class="paymentMethod === 'card' ? 'border-[#8C6D68] bg-[#FAF7F2]' : 'border-stone-200 hover:border-stone-300'">
                            <input type="radio" name="payment_method" value="card" x-model="paymentMethod" class="mt-0.5 text-[#8C6D68] focus:ring-[#8C6D68]">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-stone-900">Credit / Debit Card (Visa, Mastercard)</span>
                                    <div class="flex items-center gap-1 text-base text-stone-400">
                                        <i class="fa-brands fa-cc-visa text-blue-600"></i>
                                        <i class="fa-brands fa-cc-mastercard text-rose-500"></i>
                                    </div>
                                </div>
                                <p class="text-[11px] text-stone-500 mt-0.5">Secure card payment simulation for online orders.</p>
                            </div>
                        </label>

                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary & Coupon (5 cols) -->
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-5 sticky top-28">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-3 border-b border-stone-200">
                        Order Items ({{ $itemsCount }})
                    </h3>

                    <!-- Mini items list -->
                    <div class="max-h-64 overflow-y-auto divide-y divide-stone-100 pr-1 space-y-3">
                        @foreach($cart as $item)
                            <div class="pt-3 first:pt-0 flex items-center gap-3">
                                <div class="w-14 h-16 rounded-lg overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200 relative">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                    <span class="absolute top-0 right-0 w-4 h-4 rounded-bl bg-stone-900 text-white text-[9px] font-bold flex items-center justify-center">
                                        {{ $item['quantity'] }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0 text-xs">
                                    <h4 class="font-semibold text-stone-900 truncate">{{ $item['name'] }}</h4>
                                    <p class="text-[10px] text-stone-500">Size: {{ $item['size'] }} | {{ $item['length'] }} | {{ $item['color'] }}</p>
                                    <span class="font-bold text-[#8C6D68]">PKR {{ number_format($item['price'] * $item['quantity']) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Coupon Code Input -->
                    <div class="pt-3 border-t border-stone-100">
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Have a Discount Code?</label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   x-model="couponCode" 
                                   :disabled="couponApplied"
                                   placeholder="Try WELCOME10 or EID15" 
                                   class="flex-1 px-3 py-2 rounded-xl border border-stone-300 text-xs uppercase focus:ring-1 focus:ring-[#C5A059] disabled:bg-stone-100">
                            
                            <template x-if="!couponApplied">
                                <button type="button" 
                                        @click="applyCouponAjax()" 
                                        class="px-4 py-2 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase rounded-xl transition">
                                    Apply
                                </button>
                            </template>

                            <template x-if="couponApplied">
                                <button type="button" 
                                        @click="removeCouponAjax()" 
                                        class="px-3 py-2 bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 text-xs font-semibold rounded-xl transition">
                                    Remove
                                </button>
                            </template>
                        </div>
                        <p x-show="couponMsg" x-text="couponMsg" class="text-[11px] text-emerald-700 mt-1 font-semibold"></p>
                    </div>

                    <!-- Totals Breakdown -->
                    <div class="pt-3 border-t border-stone-200 space-y-2 text-xs text-stone-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-semibold text-stone-900">PKR {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Delivery Fee</span>
                            <span class="font-semibold {{ $shippingFee == 0 ? 'text-emerald-700' : 'text-stone-900' }}">
                                {{ $shippingFee == 0 ? 'FREE' : 'PKR ' . number_format($shippingFee) }}
                            </span>
                        </div>
                        <template x-if="couponDiscount > 0">
                            <div class="flex justify-between text-emerald-700 font-bold">
                                <span>Promo Discount</span>
                                <span>-PKR <span x-text="new Intl.NumberFormat().format(couponDiscount)"></span></span>
                            </div>
                        </template>

                        <div class="flex justify-between text-base font-bold text-stone-900 pt-3 border-t border-stone-200">
                            <span>Total Payable</span>
                            <span class="text-[#8C6D68]">
                                PKR <span x-text="new Intl.NumberFormat().format(Math.max(0, subtotal - couponDiscount + shippingFee))"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="w-full py-4 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-xl hover:shadow-2xl flex items-center justify-center gap-2 disabled:opacity-50">
                        <span x-show="!isSubmitting">Confirm & Place Order</span>
                        <span x-show="isSubmitting" class="flex items-center gap-2" x-cloak>
                            <i class="fa-solid fa-spinner animate-spin"></i>
                            <span>Processing Order...</span>
                        </span>
                    </button>

                    <div class="text-[11px] text-stone-400 text-center space-y-1">
                        <p>By placing this order, you agree to our 7-day hassle-free exchange policy.</p>
                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection
