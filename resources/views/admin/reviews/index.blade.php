@extends('layouts.admin')

@section('title', 'Reviews Moderation')
@section('header_title', 'Customer Ratings & Reviews')

@section('content')

<div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-stone-100 flex items-center justify-between">
        <div>
            <h3 class="font-serif text-base font-bold text-stone-900">Submitted Reviews</h3>
            <p class="text-xs text-stone-500">Approve or hide customer reviews across your store</p>
        </div>
        <span class="text-xs text-stone-500">{{ $reviews->total() }} Total</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                <tr>
                    <th class="py-3 px-4">Product</th>
                    <th class="py-3 px-4">Author</th>
                    <th class="py-3 px-4">Rating</th>
                    <th class="py-3 px-4">Review Content</th>
                    <th class="py-3 px-4">Date</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                @forelse($reviews as $rev)
                    <tr class="hover:bg-stone-50 transition">
                        <td class="py-3 px-4">
                            <span class="font-bold text-stone-900 block truncate max-w-xs">{{ $rev->product?->name ?? 'Deleted Product' }}</span>
                            @if($rev->product)
                                <a href="{{ route('shop.show', $rev->product->slug) }}" target="_blank" class="text-[10px] text-[#8C6D68] hover:underline">
                                    View Product &rarr;
                                </a>
                            @endif
                        </td>

                        <td class="py-3 px-4">
                            <span class="font-bold text-stone-800 block">{{ $rev->customer_name }}</span>
                            <span class="text-[10px] text-stone-400 block">{{ $rev->customer_email }}</span>
                        </td>

                        <td class="py-3 px-4">
                            <div class="flex text-amber-500 text-xs">
                                @for($i = 0; $i < $rev->rating; $i++)
                                    <i class="fa-solid fa-star"></i>
                                @endfor
                            </div>
                        </td>

                        <td class="py-3 px-4 max-w-sm">
                            @if($rev->review_title)
                                <strong class="block text-stone-900 mb-0.5">"{{ $rev->review_title }}"</strong>
                            @endif
                            <p class="text-stone-600 italic line-clamp-2">"{{ $rev->review_text }}"</p>
                        </td>

                        <td class="py-3 px-4 text-stone-400 whitespace-nowrap">
                            {{ $rev->created_at->format('M d, Y') }}
                        </td>

                        <td class="py-3 px-4 whitespace-nowrap">
                            <form action="{{ route('admin.reviews.toggle', $rev->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $rev->is_approved ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $rev->is_approved ? 'Approved' : 'Pending' }}
                                </button>
                            </form>
                        </td>

                        <td class="py-3 px-4 text-right whitespace-nowrap">
                            <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Delete this review?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 text-stone-400 hover:text-rose-600 transition" title="Delete">
                                    <i class="fa-regular fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-stone-400">No reviews submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-4 border-t border-stone-200">
        {{ $reviews->links() }}
    </div>
</div>

@endsection
