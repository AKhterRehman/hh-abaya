@extends('layouts.admin')

@section('title', 'Product Catalog')
@section('header_title', 'Abayas & Modest Catalog')

@section('content')

<div class="space-y-6">
    
    <!-- Top Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative w-full sm:w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by name, SKU..." 
                       class="w-full pl-9 pr-3 py-2 bg-[#FAF7F2] rounded-xl border border-stone-200 text-xs focus:ring-1 focus:ring-[#C5A059]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
            </div>

            <select name="category_id" onchange="this.form.submit()" class="bg-[#FAF7F2] border border-stone-200 text-stone-700 text-xs rounded-xl px-3 py-2">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" onchange="this.form.submit()" class="bg-[#FAF7F2] border border-stone-200 text-stone-700 text-xs rounded-xl px-3 py-2">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </form>

        <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow flex items-center gap-2 whitespace-nowrap">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Add New Abaya</span>
        </a>

    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Product</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price (PKR)</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Featured</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="w-12 h-16 object-cover rounded-lg border border-stone-200 flex-shrink-0">
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-stone-900 truncate max-w-xs">{{ $product->name }}</h4>
                                        <span class="text-[10px] text-stone-400 block font-mono">SKU: {{ $product->sku }}</span>
                                        @if($product->fabric)
                                            <span class="text-[10px] text-[#8C6D68] block truncate max-w-xs">{{ $product->fabric }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4 text-stone-600">
                                <span class="px-2 py-1 rounded bg-[#FAF7F2] border border-stone-200 text-[11px] font-medium">
                                    {{ $product->category?->name ?? 'Unassigned' }}
                                </span>
                            </td>

                            <td class="py-3 px-4">
                                <span class="font-bold text-stone-900 block">
                                    PKR {{ number_format($product->effective_price) }}
                                </span>
                                @if($product->has_discount)
                                    <span class="text-[10px] text-stone-400 line-through">
                                        PKR {{ number_format($product->regular_price) }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                @if($product->stock <= 5)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        {{ $product->stock }} Low Stock
                                    </span>
                                @else
                                    <span class="text-stone-700 font-semibold">
                                        {{ $product->stock }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-lg {{ $product->is_featured ? 'text-amber-500' : 'text-stone-300 hover:text-stone-500' }}" title="Toggle Featured">
                                        <i class="fa-solid fa-star"></i>
                                    </button>
                                </form>
                            </td>

                            <td class="py-3 px-4">
                                <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase transition {{ $product->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                        {{ $product->status }}
                                    </button>
                                </form>
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="p-1.5 text-stone-400 hover:text-stone-700 transition" title="Preview Live">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-1.5 text-[#C5A059] hover:text-[#A9833D] transition font-semibold" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-stone-400 hover:text-rose-600 transition" title="Delete">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-stone-400">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-[#C5A059] underline font-bold">Add your first abaya!</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $products->links() }}
        </div>
    </div>

</div>

@endsection
