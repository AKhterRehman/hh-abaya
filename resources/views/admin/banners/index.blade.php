@extends('layouts.admin')

@section('title', 'Hero Banners & Promotions')
@section('header_title', 'Hero Slider & Banners')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left: Add Banner Slide Form (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4 sticky top-24">
            <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                Add Hero Slide
            </h3>

            <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Headline Title <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required placeholder="e.g. The Autumn-Winter Luxury Edit" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059]">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Subtitle / Caption</label>
                    <textarea name="subtitle" rows="2" placeholder="Handcrafted silhouettes in premium Dubai Nidha..." class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs"></textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Badge Pill (Optional)</label>
                    <input type="text" name="badge" placeholder="e.g. New Season 2026" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Button Text</label>
                        <input type="text" name="button_text" value="Shop Collection" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Button URL</label>
                        <input type="text" name="button_link" value="/shop" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Banner Image (Wide 16:9)</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-stone-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#FAF7F2] file:text-stone-700">
                    <span class="text-[10px] text-stone-400">High resolution landscape image recommended</span>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Display Order</label>
                    <input type="number" name="sort_order" value="1" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700 pt-1">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                        <span class="font-semibold">Active in Slider</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                    Publish Slide
                </button>
            </form>
        </div>
    </div>

    <!-- Right: Existing Slides (8 cols) -->
    <div class="lg:col-span-8 space-y-4">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden p-6">
            <h3 class="font-serif text-base font-bold text-stone-900 pb-3 border-b border-stone-100 mb-4">
                Current Homepage Slides
            </h3>

            <div class="space-y-4">
                @foreach($banners as $banner)
                    <div class="rounded-xl border border-stone-200 overflow-hidden bg-[#FAF7F2] flex flex-col sm:flex-row gap-4 items-center justify-between p-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-28 h-18 aspect-video rounded-lg overflow-hidden bg-stone-900 flex-shrink-0 border border-stone-300">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                @if($banner->badge)
                                    <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-[#C5A059]/30 text-amber-900 border border-[#C5A059]/40 uppercase tracking-wider mb-1 inline-block">
                                        {{ $banner->badge }}
                                    </span>
                                @endif
                                <h4 class="font-serif font-bold text-sm text-stone-900">{{ $banner->title }}</h4>
                                <p class="text-[11px] text-stone-500 line-clamp-1">{{ $banner->subtitle }}</p>
                                <span class="text-[10px] text-stone-400 block mt-1">Button: {{ $banner->button_text }} &rarr; {{ $banner->button_link }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $banner->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $banner->is_active ? 'Active' : 'Hidden' }}
                            </span>

                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Remove this banner slide?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-600 transition" title="Delete">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
