@extends('layouts.app')

@section('title', $product->name . ' | H&H Abaya Collection')
@section('meta_description', $product->short_description)

@section('content')

@php
    $gallery = !empty($product->gallery_image_urls) ? $product->gallery_image_urls : [$product->primary_image_url];
    $selectedSize = !empty($product->sizes) ? $product->sizes[0] : 'M';
    $selectedLength = !empty($product->lengths) ? $product->lengths[0] : '54"';
    $selectedColor = !empty($product->colors) ? $product->colors[0]['name'] : 'Original';
@endphp

<!-- Breadcrumbs -->
<div class="bg-white border-b border-stone-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs text-stone-500 flex items-center space-x-2">
        <a href="{{ route('home') }}" class="hover:text-[#C5A059] transition">Home</a>
        <span>/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-[#C5A059] transition">Shop</a>
        <span>/</span>
        @if($product->category)
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-[#C5A059] transition">
                {{ $product->category->name }}
            </a>
            <span>/</span>
        @endif
        <span class="text-stone-900 font-semibold truncate">{{ $product->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" 
     x-data="{
         activeImg: 0,
         images: {{ json_encode($gallery) }},
         size: '{{ $selectedSize }}',
         length: '{{ $selectedLength }}',
         color: '{{ $selectedColor }}',
         quantity: 1,
         activeTab: 'desc'
     }">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Left Column: Image Gallery (5 cols) -->
        <div class="lg:col-span-6 space-y-4">
            
            <!-- Main Preview Image -->
            <div class="aspect-[3/4] w-full rounded-2xl overflow-hidden bg-stone-100 shadow-md border border-[#E8DDD7] relative">
                <img :src="images[activeImg]" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover transition-all duration-300">

                @if($product->has_discount)
                    <span class="absolute top-4 left-4 px-3 py-1 bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow">
                        -{{ $product->discount_percent }}% OFF
                    </span>
                @endif

                <button type="button" 
                        @click="toggleWishlist({{ $product->id }})" 
                        class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm text-stone-700 hover:text-rose-600 flex items-center justify-center transition shadow-md">
                    <i class="fa-regular fa-heart text-base"></i>
                </button>
            </div>

            <!-- Thumbnails Slider -->
            @if(count($gallery) > 1)
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                    @foreach($gallery as $index => $img)
                        <button type="button" 
                                @click="activeImg = {{ $index }}" 
                                class="aspect-[3/4] rounded-xl overflow-hidden border-2 transition relative"
                                :class="activeImg === {{ $index }} ? 'border-[#C5A059] ring-2 ring-[#C5A059]/30' : 'border-stone-200 opacity-60 hover:opacity-100'">
                            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Trust Badges Under Image -->
            <div class="p-4 rounded-xl bg-white border border-[#E8DDD7] grid grid-cols-3 gap-2 text-center text-[11px] text-stone-600">
                <div>
                    <i class="fa-solid fa-truck text-[#C5A059] block text-base mb-1"></i>
                    <span>Free delivery over Rs. 5,000</span>
                </div>
                <div>
                    <i class="fa-solid fa-arrows-rotate text-[#C5A059] block text-base mb-1"></i>
                    <span>7-day easy exchange</span>
                </div>
                <div>
                    <i class="fa-solid fa-shield-halved text-[#C5A059] block text-base mb-1"></i>
                    <span>100% genuine Nidha fabric</span>
                </div>
            </div>

        </div>

        <!-- Right Column: Product Details & Buying Actions (6 cols) -->
        <div class="lg:col-span-6 space-y-6">
            
            <div>
                <!-- Category & SKU -->
                <div class="flex items-center justify-between text-xs text-stone-500 mb-1">
                    <span class="uppercase tracking-widest font-semibold text-[#8C6D68]">
                        {{ $product->category?->name ?? 'Collection' }}
                    </span>
                    <span class="text-stone-400">SKU: {{ $product->sku }}</span>
                </div>

                <!-- Title -->
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 leading-tight">
                    {{ $product->name }}
                </h1>

                <!-- Rating -->
                <div class="flex items-center gap-2 mt-2">
                    <div class="flex text-amber-500 text-xs">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= round($product->rating) ? 'text-amber-500' : 'text-stone-300' }}"></i>
                        @endfor
                    </div>
                    <span class="text-xs font-semibold text-stone-800">{{ number_format($product->rating, 2) }}</span>
                    <span class="text-xs text-stone-400">({{ $product->reviews_count }} verified buyer reviews)</span>
                </div>
            </div>

            <!-- Price Display -->
            <div class="p-4 rounded-2xl bg-white border border-[#E8DDD7] flex items-center justify-between">
                <div>
                    <div class="flex items-baseline gap-3">
                        <span class="text-2xl font-bold text-[#8C6D68]">
                            PKR {{ number_format($product->effective_price) }}
                        </span>
                        @if($product->has_discount)
                            <span class="text-base text-stone-400 line-through">
                                PKR {{ number_format($product->regular_price) }}
                            </span>
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded">
                                Save PKR {{ number_format($product->regular_price - $product->sale_price) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] text-stone-500 mt-1">Tax included. Shipping calculated at checkout.</p>
                </div>

                <div class="text-right">
                    @if($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                            In Stock - Ready to Dispatch
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-semibold">
                            Made to Order
                        </span>
                    @endif
                </div>
            </div>

            <!-- Installment Banner -->
            <div class="p-3 bg-amber-50/60 rounded-xl border border-amber-200/80 text-xs text-stone-700 flex items-center gap-2">
                <i class="fa-solid fa-credit-card text-[#C5A059] text-base"></i>
                <span>Or pay in 3 interest-free installments of <strong class="text-stone-900">PKR {{ number_format(round($product->effective_price / 3)) }}</strong> via Bank Transfer or COD.</span>
            </div>

            <!-- Fabric highlight -->
            @if($product->fabric)
                <div class="flex items-center gap-2 text-xs text-stone-700">
                    <i class="fa-solid fa-feather text-[#C5A059]"></i>
                    <span>Fabric Composition: <strong class="text-stone-900">{{ $product->fabric }}</strong></span>
                </div>
            @endif

            <!-- Variant Selectors Form -->
            <form action="{{ route('cart.add') }}" method="POST" class="space-y-5 pt-2">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size" :value="size">
                <input type="hidden" name="length" :value="length">
                <input type="hidden" name="color" :value="color">
                <input type="hidden" name="quantity" :value="quantity">

                <!-- 1. Size Selector -->
                @if(!empty($product->sizes) && is_array($product->sizes))
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-bold text-stone-800">1. Select Standard Size:</span>
                            <button type="button" @click="sizeGuideModalOpen = true" class="text-[#8C6D68] underline font-semibold hover:text-[#C5A059] flex items-center gap-1">
                                <i class="fa-solid fa-ruler-combined"></i>
                                <span>Size Chart</span>
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($product->sizes as $sz)
                                <button type="button" 
                                        @click="size = '{{ $sz }}'" 
                                        class="px-4 py-2 text-xs font-bold rounded-xl border transition"
                                        :class="size === '{{ $sz }}' ? 'bg-[#231F20] text-white border-[#231F20] shadow-sm' : 'bg-white border-stone-300 text-stone-700 hover:border-stone-400'">
                                    {{ $sz }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 2. Abaya Length Selector (Essential for modest fashion!) -->
                @if(!empty($product->lengths) && is_array($product->lengths))
                    <div>
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="font-bold text-stone-800">2. Select Abaya Length (Inches):</span>
                            <span class="text-[11px] text-stone-500">Based on your height</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->lengths as $len)
                                <button type="button" 
                                        @click="length = '{{ $len }}'" 
                                        class="px-4 py-2 text-xs font-bold rounded-xl border transition"
                                        :class="length === '{{ $len }}' ? 'bg-[#8C6D68] text-white border-[#8C6D68] shadow-sm' : 'bg-white border-stone-300 text-stone-700 hover:border-stone-400'">
                                    {{ $len }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 3. Color Swatches -->
                @if(!empty($product->colors) && is_array($product->colors))
                    <div>
                        <div class="text-xs font-bold text-stone-800 mb-2">
                            3. Color: <span class="font-normal text-stone-600" x-text="color"></span>
                        </div>
                        <div class="flex items-center gap-3">
                            @foreach($product->colors as $col)
                                <button type="button" 
                                        @click="color = '{{ $col['name'] }}'" 
                                        class="w-9 h-9 rounded-full border-2 transition p-0.5 flex items-center justify-center"
                                        :class="color === '{{ $col['name'] }}' ? 'border-[#C5A059] ring-2 ring-[#C5A059]/40' : 'border-stone-200 hover:border-stone-400'"
                                        title="{{ $col['name'] }}">
                                    <span class="w-full h-full rounded-full border border-stone-300" style="background-color: {{ $col['code'] ?? '#000' }}"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 4. Quantity Stepper -->
                <div>
                    <span class="text-xs font-bold text-stone-800 block mb-2">4. Quantity:</span>
                    <div class="inline-flex items-center border border-stone-300 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button type="button" 
                                @click="if(quantity > 1) quantity--" 
                                class="px-4 py-2.5 text-stone-600 hover:bg-stone-100 text-xs">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                        <span class="px-5 text-sm font-bold text-stone-900" x-text="quantity"></span>
                        <button type="button" 
                                @click="quantity++" 
                                class="px-4 py-2.5 text-stone-600 hover:bg-stone-100 text-xs">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Add to Bag & Buy Now Buttons -->
                <div class="space-y-2.5 pt-2">
                    <button type="button" 
                            @click="addToCartAjax({{ $product->id }}, size, length, color, quantity)"
                            class="w-full py-4 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Add to Shopping Bag</span>
                    </button>

                    <button type="submit" 
                            name="buy_now" 
                            value="1"
                            class="w-full py-3.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Buy Now with Cash on Delivery</span>
                    </button>
                </div>

            </form>

            <!-- WhatsApp Inquire Link -->
            @php
                $whatsappMsg = "Assalam o Alaikum H&H Abaya! I am interested in " . $product->name . " (" . route('shop.show', $product->slug) . "). Can you confirm if my size is available?";
                $whatsappLink = "https://wa.me/" . \App\Models\Setting::get('store_whatsapp', '923001234567') . "?text=" . urlencode($whatsappMsg);
            @endphp
            <div class="pt-2">
                <a href="{{ $whatsappLink }}" 
                   target="_blank" 
                   class="w-full py-2.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-semibold rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-emerald-600 text-base"></i>
                    <span>Ask Questions or Request Custom Length on WhatsApp</span>
                </a>
            </div>

        </div>

    </div>

    <!-- Product Tabs (Description / Fabric Specs / Reviews / Shipping) -->
    <div class="mt-16 bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-10 shadow-sm">
        
        <!-- Tab Headers -->
        <div class="flex flex-wrap gap-4 border-b border-stone-200 pb-4 text-xs font-bold uppercase tracking-wider">
            <button type="button" 
                    @click="activeTab = 'desc'" 
                    class="pb-2 relative"
                    :class="activeTab === 'desc' ? 'text-[#8C6D68] border-b-2 border-[#8C6D68]' : 'text-stone-500 hover:text-stone-900'">
                Description & Styling
            </button>
            <button type="button" 
                    @click="activeTab = 'fabric'" 
                    class="pb-2 relative"
                    :class="activeTab === 'fabric' ? 'text-[#8C6D68] border-b-2 border-[#8C6D68]' : 'text-stone-500 hover:text-stone-900'">
                Fabric & Care
            </button>
            <button type="button" 
                    @click="activeTab = 'shipping'" 
                    class="pb-2 relative"
                    :class="activeTab === 'shipping' ? 'text-[#8C6D68] border-b-2 border-[#8C6D68]' : 'text-stone-500 hover:text-stone-900'">
                Delivery & Returns
            </button>
            <button type="button" 
                    @click="activeTab = 'reviews'" 
                    class="pb-2 relative"
                    :class="activeTab === 'reviews' ? 'text-[#8C6D68] border-b-2 border-[#8C6D68]' : 'text-stone-500 hover:text-stone-900'">
                Customer Reviews ({{ $product->reviews_count }})
            </button>
        </div>

        <!-- Tab 1: Description -->
        <div x-show="activeTab === 'desc'" class="pt-6 space-y-4 text-xs sm:text-sm text-stone-600 leading-relaxed" x-cloak>
            <div class="prose max-w-none">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>

        <!-- Tab 2: Fabric & Care -->
        <div x-show="activeTab === 'fabric'" class="pt-6 space-y-4 text-xs sm:text-sm text-stone-600 leading-relaxed" x-cloak>
            <h4 class="font-serif text-sm font-bold text-stone-900">Fabric Composition</h4>
            <p>{{ $product->fabric ?? 'Original Dubai Nidha fabric with fluid drape.' }}</p>

            <h4 class="font-serif text-sm font-bold text-stone-900 pt-2">Washing & Care Instructions</h4>
            <ul class="list-disc pl-5 space-y-1.5 text-xs text-stone-600">
                <li>Dry clean or gentle hand wash in cold water with mild liquid detergent.</li>
                <li>Do not bleach or tumble dry to preserve embroidery and fabric sheen.</li>
                <li>Steam iron on low-to-medium heat on reverse side.</li>
                <li>Hang on a padded hanger in a cool, dry place.</li>
            </ul>
        </div>

        <!-- Tab 3: Delivery & Returns -->
        <div x-show="activeTab === 'shipping'" class="pt-6 space-y-3 text-xs sm:text-sm text-stone-600 leading-relaxed" x-cloak>
            <p><strong>Nationwide Shipping (Pakistan):</strong> Standard delivery takes 3 to 5 business days via TCS / Call Courier. Orders above PKR 5,000 enjoy 100% FREE delivery.</p>
            <p><strong>Cash on Delivery:</strong> Available for all Pakistani cities. Please have the exact payment amount ready upon rider arrival.</p>
            <p><strong>7-Day Exchange Policy:</strong> If the length or size does not fit comfortably, contact our WhatsApp team within 7 days of delivery for a seamless exchange.</p>
        </div>

        <!-- Tab 4: Customer Reviews -->
        <div x-show="activeTab === 'reviews'" class="pt-6 space-y-8" x-cloak>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                
                <!-- Existing Reviews List -->
                <div class="space-y-4">
                    <h4 class="font-serif text-base font-bold text-stone-900">Verified Buyer Feedback</h4>

                    @forelse($product->reviews as $rev)
                        <div class="p-4 rounded-xl bg-[#FAF7F2] border border-[#E8DDD7] space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-stone-900">{{ $rev->customer_name }}</span>
                                <div class="flex text-amber-500 text-xs">
                                    @for($i = 0; $i < $rev->rating; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($rev->review_title)
                                <h5 class="text-xs font-semibold text-stone-800">"{{ $rev->review_title }}"</h5>
                            @endif
                            <p class="text-xs text-stone-600 italic">"{{ $rev->review_text }}"</p>
                            <span class="text-[10px] text-stone-400 block">{{ $rev->created_at->format('M d, Y') }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-stone-400">Be the first to review this product!</p>
                    @endforelse
                </div>

                <!-- Write a Review Form -->
                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-[#E8DDD7] space-y-4">
                    <h4 class="font-serif text-base font-bold text-stone-900">Write a Review</h4>
                    <form action="{{ route('shop.review.store', $product->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Your Rating:</label>
                            <select name="rating" class="w-full px-3 py-2 bg-white rounded-lg border border-stone-300 text-xs">
                                <option value="5">★★★★★ (5 Stars - Flawless Quality)</option>
                                <option value="4">★★★★☆ (4 Stars - Very Good)</option>
                                <option value="3">★★★☆☆ (3 Stars - Average)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Your Full Name:</label>
                            <input type="text" name="customer_name" required placeholder="e.g. Ayesha Khan" class="w-full px-3 py-2 bg-white rounded-lg border border-stone-300 text-xs">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Email Address:</label>
                            <input type="email" name="customer_email" required placeholder="ayesha@example.com" class="w-full px-3 py-2 bg-white rounded-lg border border-stone-300 text-xs">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Review Headline:</label>
                            <input type="text" name="review_title" placeholder="e.g. Perfect fit and luxury fabric" class="w-full px-3 py-2 bg-white rounded-lg border border-stone-300 text-xs">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Your Review:</label>
                            <textarea name="review_text" rows="3" required placeholder="Share your experience regarding fabric drape, length, and delivery..." class="w-full px-3 py-2 bg-white rounded-lg border border-stone-300 text-xs"></textarea>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-lg transition">
                            Submit Customer Review
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <div class="text-center mb-8">
                <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Complete Your Ensemble</span>
                <h3 class="font-serif text-2xl font-bold text-stone-900 mt-1">Frequently Paired Together</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProducts as $rel)
                    <x-product-card :product="$rel" />
                @endforeach
            </div>
        </div>
    @endif

</div>

@endsection
