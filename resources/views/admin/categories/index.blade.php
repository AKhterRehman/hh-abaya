@extends('layouts.admin')

@section('title', 'Categories Management')
@section('header_title', 'Collections & Categories')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left Column: Add New Category Form (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4 sticky top-24">
            <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                Add New Category
            </h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Luxury Velvet Edit" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Custom Slug (Optional)</label>
                    <input type="text" name="slug" placeholder="luxury-velvet-edit" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Description</label>
                    <textarea name="description" rows="3" placeholder="Brief silhouette & styling focus..." class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs"></textarea>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Cover / Circular Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-stone-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#FAF7F2] file:text-stone-700">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Display Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div class="space-y-2 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                        <input type="checkbox" name="is_featured" value="1" checked class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                        <span class="font-semibold">Show on Homepage Circles</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                        <span class="font-semibold">Active</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                    Save Category
                </button>
            </form>
        </div>
    </div>

    <!-- Right Column: Categories List (8 cols) -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-stone-100 flex items-center justify-between">
                <h3 class="font-serif text-base font-bold text-stone-900">Existing Collections</h3>
                <span class="text-xs text-stone-500">{{ $categories->count() }} Total</span>
            </div>

            <div class="divide-y divide-stone-100">
                @foreach($categories as $category)
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-stone-50/60 transition" x-data="{ editOpen: false }">
                        
                        <div class="flex items-center gap-3">
                            <img src="{{ $category->image ? (str_starts_with($category->image, 'http') ? $category->image : asset($category->image)) : asset('images/logo.jpg') }}" class="w-12 h-12 rounded-full object-cover ring-1 ring-[#C5A059]/40 flex-shrink-0">
                            <div>
                                <h4 class="font-serif font-bold text-sm text-stone-900">{{ $category->name }}</h4>
                                <span class="text-[11px] text-stone-400 font-mono">{{ $category->slug }}</span>
                                <span class="text-[10px] text-[#8C6D68] font-bold block mt-0.5">{{ $category->products_count }} Products Active</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $category->is_active ? 'Active' : 'Disabled' }}
                            </span>

                            <button type="button" @click="editOpen = !editOpen" class="px-3 py-1 bg-stone-100 hover:bg-[#C5A059] hover:text-white rounded-lg text-xs font-semibold transition">
                                Edit
                            </button>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? Associated products will become unassigned.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-stone-400 hover:text-rose-600 transition" title="Delete">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Inline Edit Drawer / Modal -->
                        <div x-show="editOpen" class="w-full pt-3 border-t border-stone-200 mt-2" x-cloak>
                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label class="block font-semibold mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}" required class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-1">Order</label>
                                    <input type="number" name="sort_order" value="{{ $category->sort_order }}" class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300">
                                </div>
                                <div>
                                    <label class="block font-semibold mb-1">Change Image</label>
                                    <input type="file" name="image" class="w-full text-[11px]">
                                </div>
                                <div class="sm:col-span-3 flex items-center justify-between pt-2">
                                    <label class="flex items-center gap-1.5">
                                        <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="rounded text-[#C5A059]">
                                        <span>Active</span>
                                    </label>
                                    <button type="submit" class="px-4 py-1.5 bg-[#C5A059] text-white rounded-lg font-bold">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
