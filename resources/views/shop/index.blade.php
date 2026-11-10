@extends('layouts.app')

@section('title', 'All Abayas & Khimars | H&H Abaya Collection')

@section('content')

<!-- Header Banner with subtle Islamic pattern -->
<div class="bg-[#231F20] text-white py-12 sm:py-16 border-b border-[#C5A059]/40 relative overflow-hidden islamic-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-2">
        <span class="text-[11px] uppercase tracking-[0.3em] text-[#C5A059] font-bold">Catalog</span>
        <h1 class="font-serif text-2xl sm:text-4xl font-bold tracking-tight">
            @if(request('category'))
                {{ ucwords(str_replace('-', ' ', request('category'))) }}
            @elseif(request('search'))
                Search: "{{ request('search') }}"
            @else
                The Complete Modest Collection
            @endif
        </h1>
        <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light leading-relaxed">
            Everyday minimal silhouettes, luxury evening front-opens, French khimars, and Umrah travel wear.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10" x-data="{ filterMobileOpen: false }">
    
    <!-- Quick Category Horizontal Scrolling Pills (Mobile & Tablet) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-4 scrollbar-none lg:hidden">
        <a href="{{ route('shop.index') }}" 
           class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-semibold transition border {{ !request('category') ? 'bg-[#231F20] text-white border-[#231F20]' : 'bg-white text-stone-700 border-stone-200' }}">
            All Abayas
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" 
               class="whitespace-nowrap px-4 py-2 rounded-full text-xs font-semibold transition border {{ request('category') === $cat->slug ? 'bg-[#C5A059] text-white border-[#C5A059]' : 'bg-white text-stone-700 border-stone-200' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Top Filter & Sort Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-stone-200 gap-4">
        <div class="text-xs text-stone-600">
            Showing <strong class="text-stone-900">{{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-stone-900">{{ $products->total() }}</strong> handcrafted pieces
        </div>

        <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto">
            <!-- Mobile Filter Toggle Button -->
            <button type="button" 
                    @click="filterMobileOpen = true" 
                    class="lg:hidden px-4 py-2.5 bg-white border border-stone-300 rounded-xl text-xs font-semibold text-stone-700 flex items-center gap-2 hover:bg-[#FAF7F2] shadow-sm">
                <i class="fa-solid fa-sliders text-[#C5A059]"></i>
                <span>Filter & Price</span>
            </button>

            <!-- Sort By Dropdown -->
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                @foreach(request()->except('sort', 'page') as $key => $val)
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endforeach
                <label for="sort" class="text-xs text-stone-500 hidden sm:inline">Sort By:</label>
                <select name="sort" 
                        id="sort" 
                        onchange="this.form.submit()" 
                        class="bg-white border border-stone-300 text-stone-700 text-xs rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-[#C5A059] focus:outline-none shadow-sm cursor-pointer">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Active Filters Pills -->
    @if(request('category') || request('search') || request('min_price') || request('max_price'))
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <span class="text-xs text-stone-500 font-medium">Active filters:</span>
            
            @if(request('category'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FAF7F2] border border-[#C5A059] text-xs text-stone-800">
                    Category: {{ ucwords(str_replace('-', ' ', request('category'))) }}
                    <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="hover:text-rose-600"><i class="fa-solid fa-xmark text-[10px]"></i></a>
                </span>
            @endif

            @if(request('search'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FAF7F2] border border-[#C5A059] text-xs text-stone-800">
                    Search: "{{ request('search') }}"
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-rose-600"><i class="fa-solid fa-xmark text-[10px]"></i></a>
                </span>
            @endif

            @if(request('min_price') || request('max_price'))
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FAF7F2] border border-[#C5A059] text-xs text-stone-800">
                    Price: PKR {{ request('min_price', 0) }} - {{ request('max_price', 'Any') }}
                    <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="hover:text-rose-600"><i class="fa-solid fa-xmark text-[10px]"></i></a>
                </span>
            @endif

            <a href="{{ route('shop.index') }}" class="text-xs text-rose-600 hover:underline font-semibold ml-2">
                Reset All Filters
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Desktop Sidebar Filters -->
        <aside class="hidden lg:block">
            <div class="bg-white p-6 rounded-2xl border border-[#E8DDD7] space-y-6 shadow-sm sticky top-28">
                
                <div class="flex items-center justify-between pb-4 border-b border-stone-200">
                    <h3 class="font-serif text-base font-bold text-stone-900">Filter By</h3>
                    <a href="{{ route('shop.index') }}" class="text-[11px] text-[#8C6D68] hover:text-[#C5A059] font-medium">Clear All</a>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-800 mb-3">Categories</h4>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('shop.index') }}" 
                               class="flex items-center justify-between py-1 transition {{ !request('category') ? 'text-[#8C6D68] font-bold' : 'text-stone-600 hover:text-stone-900' }}">
                                <span>All Categories</span>
                                <span class="text-stone-400">({{ $totalProducts }})</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" 
                                   class="flex items-center justify-between py-1 transition {{ request('category') === $cat->slug ? 'text-[#8C6D68] font-bold' : 'text-stone-600 hover:text-stone-900' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-stone-400">({{ $cat->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Range Filter -->
                <div class="pt-4 border-t border-stone-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-800 mb-3">Price Range (PKR)</h4>
                    <form action="{{ route('shop.index') }}" method="GET" class="space-y-3">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] text-stone-500">Min (PKR)</label>
                                <input type="number" 
                                       name="min_price" 
                                       value="{{ request('min_price') }}" 
                                       placeholder="0" 
                                       class="w-full px-2.5 py-1.5 border border-stone-300 rounded-lg text-xs">
                            </div>
                            <div>
                                <label class="text-[10px] text-stone-500">Max (PKR)</label>
                                <input type="number" 
                                       name="max_price" 
                                       value="{{ request('max_price') }}" 
                                       placeholder="15000" 
                                       class="w-full px-2.5 py-1.5 border border-stone-300 rounded-lg text-xs">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-semibold uppercase tracking-wider rounded-lg transition">
                            Apply Price
                        </button>
                    </form>
                </div>

                <!-- Custom Sizing Promo in Sidebar -->
                <div class="p-4 rounded-xl bg-[#FAF7F2] border border-[#E8DDD7] text-center space-y-2">
                    <i class="fa-solid fa-ruler-combined text-[#C5A059] text-xl"></i>
                    <h5 class="font-serif text-xs font-bold text-stone-900">Need Custom Length?</h5>
                    <p class="text-[11px] text-stone-500">We offer custom abaya lengths from 50" to 60" tailored precisely to your height.</p>
                    <button type="button" @click="sizeGuideModalOpen = true" class="text-xs text-[#8C6D68] underline font-semibold hover:text-[#C5A059]">
                        Open Size Chart &rarr;
                    </button>
                </div>

            </div>
        </aside>

        <!-- Main Product Grid -->
        <main class="lg:col-span-3">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3.5 sm:gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border border-[#E8DDD7] p-8 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center mx-auto">
                        <i class="fa-solid fa-magnifying-glass text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-stone-800">No products found</h3>
                    <p class="text-xs text-stone-500 max-w-sm mx-auto">
                        We could not find any abayas matching your specific search criteria. Try removing filters or searching for terms like "Nidha", "Khimar", or "Umrah".
                    </p>
                    <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-[#231F20] text-white text-xs font-bold uppercase tracking-wider rounded-lg hover:bg-[#8C6D68] transition">
                        View All Abayas
                    </a>
                </div>
            @endif
        </main>

    </div>

    <!-- Mobile Slide-over Drawer for Filters -->
    <div x-show="filterMobileOpen" class="fixed inset-0 z-50 lg:hidden" x-cloak>
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="filterMobileOpen = false"></div>
        <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl flex flex-col z-10 p-6 overflow-y-auto">
            <div class="flex items-center justify-between pb-4 border-b border-stone-200">
                <h3 class="font-serif text-base font-bold text-stone-900">Filters</h3>
                <button type="button" @click="filterMobileOpen = false" class="text-stone-400 hover:text-stone-700 p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="py-4 space-y-6">
                <!-- Categories -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-800 mb-3">Categories</h4>
                    <ul class="space-y-2 text-xs">
                        <li>
                            <a href="{{ route('shop.index') }}" 
                               class="flex items-center justify-between py-1.5 transition {{ !request('category') ? 'text-[#8C6D68] font-bold' : 'text-stone-600' }}">
                                <span>All Categories</span>
                                <span class="text-stone-400">({{ $totalProducts }})</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" 
                                   class="flex items-center justify-between py-1.5 transition {{ request('category') === $cat->slug ? 'text-[#8C6D68] font-bold' : 'text-stone-600' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="text-stone-400">({{ $cat->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Range Filter -->
                <div class="pt-4 border-t border-stone-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-stone-800 mb-3">Price Range (PKR)</h4>
                    <form action="{{ route('shop.index') }}" method="GET" class="space-y-3">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] text-stone-500">Min</label>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full px-2.5 py-1.5 border border-stone-300 rounded-lg text-xs">
                            </div>
                            <div>
                                <label class="text-[10px] text-stone-500">Max</label>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="15000" class="w-full px-2.5 py-1.5 border border-stone-300 rounded-lg text-xs">
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-semibold uppercase tracking-wider rounded-xl transition">
                            Apply Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
