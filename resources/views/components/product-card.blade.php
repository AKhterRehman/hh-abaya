@props(['product'])

@php
    $secondaryImage = !empty($product->gallery_images) && count($product->gallery_images) > 1 
        ? (str_starts_with($product->gallery_images[1], 'http') ? $product->gallery_images[1] : asset($product->gallery_images[1]))
        : $product->primary_image_url;
@endphp

<div class="group relative flex flex-col bg-white rounded-2xl overflow-hidden border border-[#E8DDD7]/80 hover:border-[#C5A059]/60 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_16px_36px_-6px_rgba(35,31,32,0.12)] transition-all duration-500 ease-out transform hover:-translate-y-1.5">
    
    <!-- Image Wrapper with Hover Swap -->
    <div class="relative aspect-[3/4] w-full overflow-hidden bg-[#FAF7F2]">
        
        <!-- Primary Image & Secondary Image Swap -->
        <a href="{{ route('shop.show', $product->slug) }}" class="block w-full h-full relative overflow-hidden">
            <img src="{{ $product->primary_image_url }}" 
                 alt="{{ $product->name }}" 
                 loading="lazy"
                 class="w-full h-full object-cover object-top transition-all duration-700 ease-out {{ $secondaryImage !== $product->primary_image_url ? 'group-hover:opacity-0 group-hover:scale-105' : 'group-hover:scale-110' }}">
            
            @if($secondaryImage !== $product->primary_image_url)
                <img src="{{ $secondaryImage }}" 
                     alt="{{ $product->name }}" 
                     loading="lazy"
                     class="absolute inset-0 w-full h-full object-cover object-top opacity-0 group-hover:opacity-100 transition-all duration-700 ease-out group-hover:scale-105">
            @endif

            <!-- Subtle luxury overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
        </a>

        <!-- Badges (Top Left) -->
        <div class="absolute top-2.5 left-2.5 sm:top-3 sm:left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
            @if($product->has_discount)
                <span class="px-2.5 py-1 bg-[#8C6D68] text-white text-[9px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm backdrop-blur-sm">
                    -{{ $product->discount_percent }}% OFF
                </span>
            @endif
            @if($product->is_new)
                <span class="px-2.5 py-1 bg-[#231F20]/95 text-amber-200 text-[9px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm border border-[#C5A059]/40">
                    NEW
                </span>
            @elseif($product->is_bestseller)
                <span class="px-2.5 py-1 bg-[#C5A059] text-white text-[9px] sm:text-[10px] font-bold uppercase tracking-wider rounded-md shadow-sm">
                    BESTSELLER
                </span>
            @endif
        </div>

        <!-- Wishlist Button (Top Right) -->
        <button type="button" 
                @click="toggleWishlist({{ $product->id }})" 
                class="absolute top-2.5 right-2.5 sm:top-3 sm:right-3 z-10 w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/95 backdrop-blur-md text-stone-700 hover:text-rose-600 hover:bg-white hover:scale-110 flex items-center justify-center transition-all duration-300 shadow-sm"
                title="Save to Wishlist">
            <i class="fa-regular fa-heart text-xs sm:text-sm"></i>
        </button>

        <!-- Quick Actions Overlay (Slide Up on Hover) -->
        <div class="absolute inset-x-2.5 sm:inset-x-3 bottom-2.5 sm:bottom-3 z-10 flex gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-3 group-hover:translate-y-0">
            <button type="button" 
                    @click="openQuickView({{ $product->id }})" 
                    class="flex-1 py-2 sm:py-2.5 bg-white/95 hover:bg-[#231F20] text-[#231F20] hover:text-white backdrop-blur-md text-[10px] sm:text-xs font-semibold uppercase tracking-wider rounded-xl transition-all duration-300 shadow-md flex items-center justify-center gap-1.5">
                <i class="fa-regular fa-eye text-xs"></i>
                <span class="hidden sm:inline">Quick View</span>
            </button>
            <button type="button" 
                    @click="addToCartAjax({{ $product->id }}, '{{ $product->sizes[0] ?? 'M' }}', '{{ $product->lengths[0] ?? '54\"' }}', '{{ $product->colors[0]['name'] ?? 'Original' }}')"
                    class="w-9 h-9 sm:w-10 sm:h-10 bg-[#8C6D68] hover:bg-[#735551] text-white rounded-xl shadow-md flex items-center justify-center transition-all duration-300 hover:scale-105 flex-shrink-0"
                    title="Quick Add to Bag">
                <i class="fa-solid fa-plus text-xs"></i>
            </button>
        </div>

    </div>

    <!-- Details Section -->
    <div class="p-3.5 sm:p-4 flex flex-col flex-1 justify-between bg-white relative">
        <div>
            <!-- Category & Rating -->
            <div class="flex items-center justify-between text-[10px] sm:text-[11px] text-stone-500 mb-1">
                <span class="uppercase tracking-widest text-[#8C6D68] font-semibold truncate max-w-[65%]">
                    {{ $product->category?->name ?? 'Collection' }}
                </span>
                <div class="flex items-center text-amber-500 text-[10px]">
                    <i class="fa-solid fa-star"></i>
                    <span class="ml-1 font-semibold text-stone-700">{{ number_format($product->rating, 1) }}</span>
                </div>
            </div>

            <!-- Product Title -->
            <h3 class="font-serif text-xs sm:text-sm font-bold text-stone-900 group-hover:text-[#C5A059] transition-colors duration-300 line-clamp-1 leading-snug">
                <a href="{{ route('shop.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>

            <!-- Fabric Info -->
            @if($product->fabric)
                <p class="text-[10px] sm:text-[11px] text-stone-400 truncate mt-0.5 font-light">
                    {{ $product->fabric }}
                </p>
            @endif
        </div>

        <div class="mt-2.5 sm:mt-3 pt-2 sm:pt-2.5 border-t border-stone-100 flex items-center justify-between">
            <!-- Price Display -->
            <div class="flex items-baseline gap-1.5 sm:gap-2">
                <span class="text-xs sm:text-sm font-bold text-[#8C6D68]">
                    PKR {{ number_format($product->effective_price) }}
                </span>
                @if($product->has_discount)
                    <span class="text-[10px] sm:text-xs text-stone-400 line-through">
                        PKR {{ number_format($product->regular_price) }}
                    </span>
                @endif
            </div>

            <!-- Color Swatches Preview -->
            @if(!empty($product->colors) && is_array($product->colors))
                <div class="flex items-center -space-x-1">
                    @foreach(array_slice($product->colors, 0, 3) as $col)
                        <span class="inline-block w-3 h-3 sm:w-3.5 sm:h-3.5 rounded-full border-2 border-white shadow-sm ring-1 ring-stone-200" 
                              style="background-color: {{ $col['code'] ?? '#000' }}"
                              title="{{ $col['name'] ?? '' }}"></span>
                    @endforeach
                    @if(count($product->colors) > 3)
                        <span class="text-[8px] sm:text-[9px] text-stone-400 pl-1 font-bold">+{{ count($product->colors) - 3 }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>
