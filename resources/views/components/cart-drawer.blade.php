<!-- Slide-over Cart Drawer -->
<div x-show="cartDrawerOpen" 
     class="fixed inset-0 z-50 overflow-hidden" 
     x-cloak>
    
    <!-- Backdrop -->
    <div x-show="cartDrawerOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm" 
         @click="cartDrawerOpen = false"></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div x-show="cartDrawerOpen" 
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="w-screen max-w-md bg-white shadow-2xl flex flex-col border-l border-[#E8DDD7]">
            
            <!-- Drawer Header -->
            <div class="p-5 border-b border-[#E8DDD7] bg-[#FAF7F2] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-bag-shopping text-[#8C6D68]"></i>
                    <h3 class="font-serif text-base font-bold text-[#231F20] tracking-wide">
                        Your Shopping Bag (<span x-text="cartData.itemsCount"></span>)
                    </h3>
                </div>
                <button type="button" @click="cartDrawerOpen = false" class="p-1.5 text-stone-400 hover:text-stone-800 rounded-full hover:bg-stone-200/50 transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Free Shipping Progress Bar -->
            <div class="px-5 py-3 bg-[#FBF8F5] border-b border-[#E8DDD7]">
                <template x-if="!cartData.isFreeShipping && cartData.subtotal > 0">
                    <div>
                        <div class="flex items-center justify-between text-[11px] font-medium text-stone-700 mb-1.5">
                            <span>Add <strong class="text-[#8C6D68]">PKR <span x-text="new Intl.NumberFormat().format(cartData.amountNeededForFreeShipping)"></span></strong> more for <span class="text-emerald-700 font-bold uppercase">Free Shipping</span></span>
                            <span class="font-bold text-[#8C6D68]" x-text="cartData.freeShippingProgress + '%'"></span>
                        </div>
                        <div class="w-full h-2 bg-stone-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-[#C5A059] to-[#8C6D68] transition-all duration-500 rounded-full" 
                                 :style="`width: ${cartData.freeShippingProgress}%`"></div>
                        </div>
                    </div>
                </template>
                <template x-if="cartData.isFreeShipping && cartData.subtotal > 0">
                    <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>Congratulations! You qualify for <strong>FREE Nationwide Delivery!</strong></span>
                    </div>
                </template>
                <template x-if="cartData.subtotal === 0">
                    <div class="text-[11px] text-stone-500 text-center">
                        Free delivery on orders above PKR 5,000 nationwide.
                    </div>
                </template>
            </div>

            <!-- Cart Items List -->
            <div class="flex-1 overflow-y-auto p-5 space-y-4">
                
                <!-- Empty State -->
                <template x-if="Object.keys(cartData.cart).length === 0">
                    <div class="text-center py-16 space-y-4">
                        <div class="w-16 h-16 rounded-full bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center mx-auto ring-1 ring-[#E8DDD7]">
                            <i class="fa-solid fa-bag-shopping text-2xl"></i>
                        </div>
                        <h4 class="font-serif text-lg font-semibold text-stone-800">Your bag is empty</h4>
                        <p class="text-xs text-stone-500 max-w-xs mx-auto">
                            Explore our latest handcrafted abayas, French khimars, and modest coordinates.
                        </p>
                        <a href="{{ route('shop.index') }}" 
                           @click="cartDrawerOpen = false"
                           class="inline-block px-6 py-2.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-semibold uppercase tracking-wider rounded-lg transition shadow">
                            Start Shopping
                        </a>
                    </div>
                </template>

                <!-- Items Loop -->
                <template x-for="(item, key) in cartData.cart" :key="key">
                    <div class="flex gap-4 p-3 rounded-xl bg-[#FAF7F2] border border-[#E8DDD7]/70 relative group">
                        
                        <!-- Thumbnail -->
                        <div class="w-20 h-24 rounded-lg overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        </div>

                        <!-- Details -->
                        <div class="flex-1 min-w-0 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-2">
                                    <h5 class="text-xs font-bold text-stone-900 truncate hover:text-[#C5A059] transition">
                                        <a :href="'/shop/' + item.slug" x-text="item.name"></a>
                                    </h5>
                                    <button type="button" 
                                            @click="removeCartItem(item.key)" 
                                            class="text-stone-400 hover:text-rose-600 transition p-1"
                                            title="Remove item">
                                        <i class="fa-regular fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-2 text-[10px] text-stone-500 mt-1">
                                    <span class="px-1.5 py-0.5 bg-white rounded border border-stone-200" x-text="'Size: ' + item.size"></span>
                                    <span class="px-1.5 py-0.5 bg-white rounded border border-stone-200" x-text="'Length: ' + item.length"></span>
                                    <span class="px-1.5 py-0.5 bg-white rounded border border-stone-200" x-text="item.color"></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-stone-200/60">
                                <!-- Quantity Adjuster -->
                                <div class="flex items-center border border-stone-300 rounded-lg bg-white overflow-hidden">
                                    <button type="button" 
                                            @click="updateCartQuantity(item.key, item.quantity - 1)" 
                                            :disabled="item.quantity <= 1"
                                            class="px-2 py-0.5 text-stone-600 hover:bg-stone-100 disabled:opacity-30 text-xs">
                                        <i class="fa-solid fa-minus text-[9px]"></i>
                                    </button>
                                    <span class="px-2.5 text-xs font-bold text-stone-800" x-text="item.quantity"></span>
                                    <button type="button" 
                                            @click="updateCartQuantity(item.key, item.quantity + 1)" 
                                            class="px-2 py-0.5 text-stone-600 hover:bg-stone-100 text-xs">
                                        <i class="fa-solid fa-plus text-[9px]"></i>
                                    </button>
                                </div>

                                <!-- Line Price -->
                                <div class="text-right">
                                    <span class="text-xs font-bold text-[#8C6D68]" 
                                          x-text="'PKR ' + new Intl.NumberFormat().format(item.price * item.quantity)">
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </template>

            </div>

            <!-- Drawer Footer (Subtotal & Checkout CTA) -->
            <div x-show="Object.keys(cartData.cart).length > 0" class="p-5 bg-white border-t border-[#E8DDD7] space-y-3">
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between text-stone-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-stone-900" x-text="'PKR ' + new Intl.NumberFormat().format(cartData.subtotal)"></span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Shipping</span>
                        <span class="font-semibold" 
                              :class="cartData.shippingFee === 0 ? 'text-emerald-700' : 'text-stone-900'"
                              x-text="cartData.shippingFee === 0 ? 'FREE' : 'PKR ' + new Intl.NumberFormat().format(cartData.shippingFee)"></span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-stone-900 pt-2 border-t border-stone-200">
                        <span>Estimated Total</span>
                        <span class="text-[#8C6D68]" x-text="'PKR ' + new Intl.NumberFormat().format(cartData.total)"></span>
                    </div>
                </div>

                <div class="space-y-2 pt-2">
                    <a href="{{ route('checkout.index') }}" 
                       class="w-full py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <span>Proceed to Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ route('cart.index') }}" 
                       @click="cartDrawerOpen = false"
                       class="w-full py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold uppercase tracking-wider rounded-xl transition text-center block">
                        View Full Bag
                    </a>
                </div>

                <div class="text-[11px] text-stone-400 text-center flex items-center justify-center gap-3 pt-1">
                    <span><i class="fa-solid fa-lock text-[10px] mr-1"></i> Secure Checkout</span>
                    <span>•</span>
                    <span><i class="fa-solid fa-box text-[10px] mr-1"></i> Cash on Delivery</span>
                </div>
            </div>

        </div>
    </div>
</div>
