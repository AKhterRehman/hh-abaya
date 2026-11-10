@extends('layouts.admin')

@section('title', 'Edit ' . $product->name)
@section('header_title', 'Edit Product: ' . $product->name)

@section('content')

<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="text-xs text-stone-500 hover:text-stone-800 flex items-center gap-1 font-semibold">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
        <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="text-xs text-[#8C6D68] hover:text-[#C5A059] font-bold">
            <i class="fa-regular fa-eye mr-1"></i> View on Live Store
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left Column: Details (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- General Info Card -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                        Product Details
                    </h3>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Product Title <span class="text-rose-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name', $product->name) }}" 
                               required 
                               class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Custom Slug</label>
                            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">SKU / Code</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Fabric & Texture Composition</label>
                        <input type="text" name="fabric" value="{{ old('fabric', $product->fabric) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Short Summary</label>
                        <textarea name="short_description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">{{ old('short_description', $product->short_description) }}</textarea>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Detailed Description & Styling Notes</label>
                        <textarea name="description" rows="5" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <!-- Sizes & Abaya Lengths -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                        Available Sizes & Lengths
                    </h3>

                    @php
                        $curSizes = is_array($product->sizes) ? $product->sizes : [];
                        $curLengths = is_array($product->lengths) ? $product->lengths : [];
                        $curColors = is_array($product->colors) ? $product->colors : [];
                    @endphp

                    <!-- Sizes checkboxes -->
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-2">Available Standard Sizes:</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL', 'Free Size'] as $sz)
                                <label class="flex items-center gap-2 p-2 px-3 rounded-lg border border-stone-300 text-xs cursor-pointer hover:bg-stone-50">
                                    <input type="checkbox" name="sizes[]" value="{{ $sz }}" {{ in_array($sz, $curSizes) ? 'checked' : '' }} class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                                    <span class="font-semibold">{{ $sz }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Abaya Lengths checkboxes -->
                    <div class="pt-2">
                        <label class="text-xs font-semibold text-stone-700 block mb-2">Available Abaya Lengths (Inches):</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['50"', '52"', '54"', '56"', '58"', '60"'] as $len)
                                <label class="flex items-center gap-2 p-2 px-3 rounded-lg border border-stone-300 text-xs cursor-pointer hover:bg-stone-50">
                                    <input type="checkbox" name="lengths[]" value="{{ $len }}" {{ in_array($len, $curLengths) ? 'checked' : '' }} class="rounded text-[#8C6D68] focus:ring-[#8C6D68]">
                                    <span class="font-semibold">{{ $len }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Color Swatches Input -->
                    <div class="pt-2" x-data="{ colorsList: {{ json_encode($curColors ?: [['name' => 'Original', 'code' => '#111111']]) }} }">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-semibold text-stone-700">Colors / Shades:</label>
                            <button type="button" @click="colorsList.push({ name: '', code: '#C5A059' })" class="text-xs text-[#C5A059] hover:underline font-bold">
                                + Add Color
                            </button>
                        </div>
                        <div class="space-y-2">
                            <template x-for="(col, i) in colorsList" :key="i">
                                <div class="flex items-center gap-2">
                                    <input type="text" name="color_names[]" x-model="col.name" placeholder="Color Name" class="flex-1 px-3 py-1.5 rounded-lg border border-stone-300 text-xs">
                                    <input type="color" name="color_codes[]" x-model="col.code" class="w-10 h-8 rounded border border-stone-300 p-0.5 cursor-pointer">
                                    <button type="button" @click="colorsList.splice(i, 1)" class="text-stone-400 hover:text-rose-600 p-1">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Right Column: Pricing, Category & Images (1 col) -->
            <div class="space-y-6">
                
                <!-- Category & Inventory -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                        Category & Stock
                    </h3>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Category</label>
                        <select name="category_id" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Regular Price (PKR) <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}" required class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-bold text-stone-900">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Sale Price (PKR)</label>
                        <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-bold text-[#8C6D68]">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Stock Quantity</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>

                    <div class="pt-2 border-t border-stone-100 space-y-2">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                            <span class="font-semibold">Featured on Homepage</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                            <input type="checkbox" name="is_new" value="1" {{ $product->is_new ? 'checked' : '' }} class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                            <span class="font-semibold">Badge: New Arrival</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700">
                            <input type="checkbox" name="is_bestseller" value="1" {{ $product->is_bestseller ? 'checked' : '' }} class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                            <span class="font-semibold">Badge: Best Seller</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active (Visible on Storefront)</option>
                            <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                        </select>
                    </div>
                </div>

                <!-- Image Uploads & Current Previews -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                        Product Imagery
                    </h3>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Current Primary Image:</label>
                        <div class="w-20 h-24 rounded-lg overflow-hidden border border-stone-300 mb-2">
                            <img src="{{ $product->primary_image_url }}" class="w-full h-full object-cover">
                        </div>
                        <input type="file" name="primary_image" accept="image/*" class="w-full text-xs text-stone-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#FAF7F2] file:text-stone-700">
                    </div>

                    @if(!empty($product->gallery_images))
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Current Gallery ({{ count($product->gallery_images) }}):</label>
                            <div class="flex gap-2 overflow-x-auto pb-1 mb-2">
                                @foreach($product->gallery_image_urls as $gImg)
                                    <img src="{{ $gImg }}" class="w-12 h-14 object-cover rounded border border-stone-200 flex-shrink-0">
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Add More Gallery Images</label>
                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="w-full text-xs text-stone-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#FAF7F2] file:text-stone-700">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-xl">
                    Update Abaya Changes
                </button>

            </div>

        </div>

    </form>

</div>

@endsection
