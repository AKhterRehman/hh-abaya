@extends('layouts.app')

@section('title', 'H&H Abaya Collection | Handcrafted Luxury Modest Fashion')

@section('content')

<!-- 1. Hero Banner Slider -->
<section class="relative bg-stone-900 overflow-hidden" 
         x-data="{
             currentSlide: 0,
             totalSlides: {{ count($banners) > 0 ? count($banners) : 1 }},
             autoSlide() {
                 setInterval(() => {
                     this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                 }, 6000);
             }
         }"
         x-init="autoSlide()">
    
    <div class="relative h-[480px] sm:h-[580px] lg:h-[680px] w-full">
        @forelse($banners as $index => $banner)
            <div x-show="currentSlide === {{ $index }}" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-700"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute inset-0 w-full h-full"
                 x-cloak>
                
                <!-- Background Image & Luxury Overlay -->
                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover object-top filter brightness-[0.75]">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>

                <!-- Text Content -->
                <div class="absolute inset-0 max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 flex flex-col justify-center">
                    <div class="max-w-xl text-white space-y-4">
                        @if($banner->badge)
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#C5A059]/30 border border-[#C5A059]/60 text-amber-200 text-xs font-semibold uppercase tracking-widest backdrop-blur-sm">
                                <i class="fa-solid fa-sparkles text-[10px]"></i>
                                <span>{{ $banner->badge }}</span>
                            </div>
                        @endif

                        <h1 class="font-serif text-3xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-white leading-tight">
                            {{ $banner->title }}
                        </h1>

                        <p class="text-sm sm:text-base text-stone-300 font-light leading-relaxed max-w-md">
                            {{ $banner->subtitle }}
                        </p>

                        <div class="pt-2 flex flex-wrap items-center gap-4">
                            <a href="{{ $banner->button_link }}" 
                               class="px-8 py-3.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition duration-300 shadow-xl hover:shadow-2xl flex items-center gap-2">
                                <span>{{ $banner->button_text }}</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('shop.index') }}" 
                               class="px-7 py-3.5 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold uppercase tracking-widest rounded-xl transition backdrop-blur-md border border-white/20">
                                View Lookbook
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="absolute inset-0 bg-gradient-to-r from-stone-900 to-stone-800 flex items-center justify-center text-white">
                <div class="text-center space-y-3">
                    <h1 class="font-serif text-4xl">H&H Abaya Collection</h1>
                    <p class="text-stone-400 text-sm">Handcrafted Luxury Modest Wear</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Slider Navigation Dots -->
    @if(count($banners) > 1)
        <div class="absolute bottom-6 inset-x-0 flex items-center justify-center space-x-2 z-20">
            @foreach($banners as $index => $banner)
                <button type="button" 
                        @click="currentSlide = {{ $index }}" 
                        class="h-2 rounded-full transition-all duration-300"
                        :class="currentSlide === {{ $index }} ? 'w-8 bg-[#C5A059]' : 'w-2 bg-white/50 hover:bg-white'">
                </button>
            @endforeach
        </div>
    @endif
</section>

<!-- 2. Value Propositions Bar -->
<section class="border-y border-[#E8DDD7] bg-white py-6 islamic-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left stagger-children reveal">
            
            <div class="flex flex-col md:flex-row items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl flex-shrink-0 ring-1 ring-[#E8DDD7]">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900">Original Dubai Nidha</h4>
                    <p class="text-[11px] text-stone-500">100% genuine breathable fabrics</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl flex-shrink-0 ring-1 ring-[#E8DDD7]">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900">Cash on Delivery</h4>
                    <p class="text-[11px] text-stone-500">Available across all cities in Pakistan</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl flex-shrink-0 ring-1 ring-[#E8DDD7]">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900">7-Day Free Exchange</h4>
                    <p class="text-[11px] text-stone-500">Hassle-free size & length exchanges</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl flex-shrink-0 ring-1 ring-[#E8DDD7]">
                    <i class="fa-solid fa-ruler-combined"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-900">Custom Sizing (50"-60")</h4>
                    <p class="text-[11px] text-stone-500">Tailored length matching your height</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3. Curated Category Story Circles / Grid -->
<section class="py-14 bg-[#FAF7F2] islamic-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-10 space-y-2 reveal">
            <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Curated Silhouettes</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-[#231F20]">Explore By Collection</h2>
            <div class="ornament-divider justify-center max-w-xs mx-auto pt-2">
                <span class="ornament-icon">✦</span>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6 stagger-children reveal">
            @foreach($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                   class="group flex flex-col items-center text-center p-3 rounded-2xl bg-white border border-[#E8DDD7] hover:border-[#C5A059] card-hover-lift transition-all duration-400">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden p-1 border-2 border-dashed border-[#C5A059]/40 group-hover:border-[#C5A059] group-hover:border-solid transition-all duration-500 bg-[#FAF7F2] mb-3 img-zoom-hover">
                        <img src="{{ $category->image ? (str_starts_with($category->image, 'http') ? $category->image : asset($category->image)) : asset('images/logo.jpg') }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-cover rounded-full">
                    </div>
                    <h3 class="font-serif text-xs font-bold text-stone-900 group-hover:text-[#C5A059] transition-colors leading-tight line-clamp-1">
                        {{ $category->name }}
                    </h3>
                    <span class="text-[10px] text-stone-400 mt-1 uppercase tracking-wider">
                        Explore &rarr;
                    </span>
                </a>
            @endforeach
        </div>

    </div>
</section>

<!-- 4. Featured Product Tabs (Bestsellers / New Arrivals / Featured) -->
<section class="py-16 bg-white border-t border-[#E8DDD7]" x-data="{ activeTab: 'featured' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 pb-4 border-b border-stone-200 gap-4 reveal">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Handcrafted Elegance</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 mt-1">Signature Collections</h2>
            </div>

            <!-- Tab Buttons -->
            <div class="flex items-center space-x-2 bg-[#FAF7F2] p-1.5 rounded-xl border border-[#E8DDD7] text-xs font-semibold">
                <button type="button" 
                        @click="activeTab = 'featured'" 
                        class="px-4 py-2 rounded-lg transition"
                        :class="activeTab === 'featured' ? 'bg-[#231F20] text-white shadow-sm' : 'text-stone-600 hover:text-stone-900'">
                    Featured
                </button>
                <button type="button" 
                        @click="activeTab = 'bestsellers'" 
                        class="px-4 py-2 rounded-lg transition"
                        :class="activeTab === 'bestsellers' ? 'bg-[#231F20] text-white shadow-sm' : 'text-stone-600 hover:text-stone-900'">
                    Best Sellers
                </button>
                <button type="button" 
                        @click="activeTab = 'new'" 
                        class="px-4 py-2 rounded-lg transition"
                        :class="activeTab === 'new' ? 'bg-[#231F20] text-white shadow-sm' : 'text-stone-600 hover:text-stone-900'">
                    New Arrivals
                </button>
            </div>
        </div>

        <!-- Featured Tab Content -->
        <div x-show="activeTab === 'featured'" x-cloak>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <!-- Bestsellers Tab Content -->
        <div x-show="activeTab === 'bestsellers'" x-cloak>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($bestsellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <!-- New Arrivals Tab Content -->
        <div x-show="activeTab === 'new'" x-cloak>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($newArrivals as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('shop.index') }}" 
               class="inline-flex items-center gap-2 px-8 py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow">
                <span>View All Collections ({{ \App\Models\Product::active()->count() }})</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

    </div>
</section>

<!-- 5. "Build Your Look" / Bundle Offer (Signature feature inspired by sitrofficial.com) -->
<section class="py-16 bg-[#FBF8F5] border-t border-[#E8DDD7] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-br from-[#231F20] to-[#362C2A] rounded-3xl p-8 sm:p-12 text-white shadow-2xl border border-[#C5A059]/30 relative overflow-hidden">
            
            <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-[#C5A059]/10 blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                
                <div class="space-y-4">
                    <span class="inline-block px-3 py-1 rounded-full bg-[#C5A059]/30 border border-[#C5A059] text-amber-200 text-xs font-semibold uppercase tracking-widest">
                        ✨ Bestseller Bundle Offer
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold leading-tight">
                        Build Your Modest Look & Save 15%
                    </h2>
                    <p class="text-xs sm:text-sm text-stone-300 leading-relaxed max-w-md">
                        Pair any handcrafted Abaya with our French Khimar and luxury crinkle shayla. Enjoy full coverage, complimentary matching fabric mask, and free nationwide delivery.
                    </p>

                    <ul class="space-y-2 text-xs text-stone-300 pt-2">
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-[#C5A059]"></i>
                            <span>1x Handcrafted Saudi Nidha Abaya (Your Choice)</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-[#C5A059]"></i>
                            <span>1x Matching French Khimar or Chiffon Shayla</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-check text-[#C5A059]"></i>
                            <span>Complimentary Premium Magnetic Hijab Pins Set</span>
                        </li>
                    </ul>

                    <div class="pt-4 flex items-center gap-4">
                        <a href="{{ route('shop.index', ['category' => 'khimar-sets']) }}" 
                           class="px-8 py-3.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-lg">
                            Shop Bundles Now
                        </a>
                        <span class="text-xs text-amber-200 font-medium">Use code <strong class="underline">EID15</strong> at checkout</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-md ring-1 ring-white/20">
                        <img src="https://images.unsplash.com/photo-1616902504573-5beee79ad6db?auto=format&fit=crop&w=600&q=80" alt="Khimar Set" class="w-full h-full object-cover">
                    </div>
                    <div class="aspect-[3/4] rounded-2xl overflow-hidden shadow-md ring-1 ring-white/20 mt-6">
                        <img src="https://images.unsplash.com/photo-1569245087840-dcf487ddbad5?auto=format&fit=crop&w=600&q=80" alt="Luxury Abaya" class="w-full h-full object-cover">
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>

<!-- 6. The Umrah Edit Spotlight -->
@if($umrahCollection->count() > 0)
<section class="py-16 bg-white border-t border-[#E8DDD7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 pb-4 border-b border-stone-200 gap-4">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Pilgrimage Essentials</span>
                <h2 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 mt-1">The Umrah & Hajj Edit</h2>
                <p class="text-xs text-stone-500 mt-1">Breathable, non-transparent, crease-resistant travel abayas crafted for worship.</p>
            </div>
            <a href="{{ route('shop.index', ['category' => 'the-umrah-edit']) }}" class="text-xs font-bold uppercase tracking-wider text-[#8C6D68] hover:text-[#C5A059] flex items-center gap-1.5">
                <span>View Full Umrah Line</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            @foreach($umrahCollection as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- 7. Brand Story & Craftsmanship Banner -->
<section class="py-16 bg-[#FAF7F2] border-t border-[#E8DDD7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <div class="lg:col-span-5 relative">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl ring-2 ring-[#C5A059]/40 border-4 border-white">
                    <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya Craftsmanship" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-2xl shadow-xl border border-[#E8DDD7] max-w-[200px] text-center hidden sm:block">
                    <span class="block font-serif text-2xl font-bold text-[#C5A059]">100%</span>
                    <span class="text-[10px] uppercase font-bold text-stone-600">Tailored In Pakistan With Imported Saudi Fabrics</span>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-5 lg:pl-6">
                <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">The Art of Refined Modesty</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900 leading-tight">
                    Every Stitch Sown with Dignity, Reverence & Craft
                </h2>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                    {{ \App\Models\Setting::get('about_story') }}
                </p>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 bg-white rounded-xl border border-[#E8DDD7]">
                        <h4 class="font-serif text-sm font-bold text-stone-900">Custom Length Guarantee</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Whether 50" or 60", choose your tailored length for an effortless drape without tripping or dragging.</p>
                    </div>
                    <div class="p-4 bg-white rounded-xl border border-[#E8DDD7]">
                        <h4 class="font-serif text-sm font-bold text-stone-900">Premium Dubai Nidha</h4>
                        <p class="text-[11px] text-stone-500 mt-1">Silky smooth touch, breathable airflow for our weather, and non-see-through opacity.</p>
                    </div>
                </div>

                <div class="pt-3">
                    <a href="{{ route('pages.about') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#8C6D68] hover:text-[#C5A059] transition">
                        <span>Read Our Full Story</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 8. Verified Customer Reviews -->
<section class="py-16 bg-white border-t border-[#E8DDD7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-12 space-y-2">
            <div class="flex items-center justify-center gap-1 text-amber-500 text-sm">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <span class="text-xs text-stone-700 font-bold ml-1">4.95 / 5.0 Rating</span>
            </div>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900">Loved by Modest Women Nationwide</h2>
            <p class="text-xs text-stone-500">Real feedback from verified customers across Pakistan & Overseas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($reviews as $rev)
                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-[#E8DDD7] flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex text-amber-500 text-xs">
                                @for($i = 0; $i < $rev->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                            <span class="text-[10px] text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-circle-check text-[9px]"></i> Verified Buyer
                            </span>
                        </div>
                        @if($rev->review_title)
                            <h4 class="font-serif text-sm font-bold text-stone-900 mb-1">"{{ $rev->review_title }}"</h4>
                        @endif
                        <p class="text-xs text-stone-600 leading-relaxed italic">
                            "{{ $rev->review_text }}"
                        </p>
                    </div>

                    <div class="pt-3 border-t border-stone-200/60 flex items-center justify-between text-xs">
                        <div>
                            <span class="font-bold text-stone-900 block">{{ $rev->customer_name }}</span>
                            <span class="text-[10px] text-stone-400">on {{ $rev->product?->name ?? 'H&H Abaya' }}</span>
                        </div>
                        <i class="fa-solid fa-quote-right text-stone-300 text-xl"></i>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-xs text-stone-400">
                    Verified reviews will appear here.
                </div>
            @endforelse
        </div>

    </div>
</section>

<!-- 9. Instagram / Community Feed Preview -->
<section class="py-14 bg-[#FAF7F2] border-t border-[#E8DDD7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 mb-8">
        <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">@HHAbayaCollection</span>
        <h2 class="font-serif text-2xl font-bold text-stone-900">Tag Us in Your Looks</h2>
        <p class="text-xs text-stone-500 max-w-md mx-auto">Follow our journey on Instagram for daily abaya styling tutorials, Umrah lookbooks, and behind-the-scenes tailoring.</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1569245087840-dcf487ddbad5?auto=format&fit=crop&w=400&q=80" alt="Abaya style" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1616902504573-5beee79ad6db?auto=format&fit=crop&w=400&q=80" alt="Hijab fashion" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1601267445524-663731fd40fb?auto=format&fit=crop&w=400&q=80" alt="Modest fashion" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1542816417-0983c9c7ad53?auto=format&fit=crop&w=400&q=80" alt="Hijabi style" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1609599006353-e629aaabfeae?auto=format&fit=crop&w=400&q=80" alt="Abaya collection" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
            <div class="aspect-square rounded-xl overflow-hidden relative group">
                <img src="https://images.unsplash.com/photo-1564769625905-50e93615e769?auto=format&fit=crop&w=400&q=80" alt="Modest wear" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-center justify-center text-white text-xl">
                    <i class="fa-brands fa-instagram transform group-hover:rotate-12 transition-transform duration-300"></i>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
