@extends('layouts.app')

@section('title', 'Your Wishlist | H&H Abaya Collection')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="text-center max-w-xl mx-auto mb-10 space-y-2">
        <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Saved Favorites</span>
        <h1 class="font-serif text-3xl font-bold text-stone-900">Your Wishlist</h1>
        <p class="text-xs text-stone-500">Save items you love to revisit or purchase later.</p>
    </div>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                @if($item->product)
                    <div class="relative">
                        <x-product-card :product="$item->product" />
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-3xl border border-[#E8DDD7] p-8 max-w-md mx-auto space-y-4">
            <div class="w-16 h-16 rounded-full bg-[#FAF7F2] text-rose-500 flex items-center justify-center mx-auto">
                <i class="fa-regular fa-heart text-2xl"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-stone-800">Your wishlist is empty</h3>
            <p class="text-xs text-stone-500">
                Tap the heart icon on any abaya, khimar, or namaz chadar to save your favorite styles here.
            </p>
            <a href="{{ route('shop.index') }}" class="inline-block px-7 py-3 bg-[#231F20] text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-[#8C6D68] transition shadow">
                Explore The Collection
            </a>
        </div>
    @endif

</div>

@endsection
