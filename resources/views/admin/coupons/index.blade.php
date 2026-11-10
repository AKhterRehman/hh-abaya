@extends('layouts.admin')

@section('title', 'Coupons & Discounts')
@section('header_title', 'Discount Codes & Promotions')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    <!-- Left: Create Coupon Form (4 cols) -->
    <div class="lg:col-span-4">
        <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4 sticky top-24">
            <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                Create Discount Code
            </h3>

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Coupon Code <span class="text-rose-500">*</span></label>
                    <input type="text" name="code" required placeholder="e.g. EID20" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-mono uppercase focus:ring-2 focus:ring-[#C5A059]">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Discount Type</label>
                        <select name="type" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs bg-white">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (PKR)</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Value <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="value" required placeholder="10" class="w-full px-3 py-2 rounded-xl border border-stone-300 text-xs font-bold">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Minimum Order Amount (PKR)</label>
                    <input type="number" step="0.01" name="min_order_amount" value="3000" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">Max Usages Limit</label>
                    <input type="number" name="usage_limit" placeholder="e.g. 500" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-stone-700 pt-1">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-[#C5A059] focus:ring-[#C5A059]">
                        <span class="font-semibold">Active & Redeemable</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                    Create Coupon
                </button>
            </form>
        </div>
    </div>

    <!-- Right: Coupons Table (8 cols) -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-stone-100 flex items-center justify-between">
                <h3 class="font-serif text-base font-bold text-stone-900">Active Coupons</h3>
                <span class="text-xs text-stone-500">{{ $coupons->total() }} Total</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">Code</th>
                            <th class="py-3 px-4">Discount</th>
                            <th class="py-3 px-4">Min. Spend</th>
                            <th class="py-3 px-4">Redeemed</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($coupons as $coupon)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="py-3 px-4 font-mono font-bold text-stone-900 text-sm">
                                    {{ $coupon->code }}
                                </td>

                                <td class="py-3 px-4 font-bold text-[#8C6D68]">
                                    {{ $coupon->type === 'percentage' ? $coupon->value . '%' : 'PKR ' . number_format($coupon->value) }}
                                </td>

                                <td class="py-3 px-4 text-stone-600">
                                    {{ $coupon->min_order_amount > 0 ? 'PKR ' . number_format($coupon->min_order_amount) : 'No Minimum' }}
                                </td>

                                <td class="py-3 px-4 text-stone-600 font-semibold">
                                    {{ $coupon->used_count }} {{ $coupon->usage_limit ? '/ ' . $coupon->usage_limit : 'uses' }}
                                </td>

                                <td class="py-3 px-4">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                        {{ $coupon->is_active ? 'Active' : 'Disabled' }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 text-right">
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Delete this coupon?');" class="inline">
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
                                <td colspan="6" class="text-center py-8 text-stone-400">No coupons created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-stone-200">
                {{ $coupons->links() }}
            </div>
        </div>
    </div>

</div>

@endsection
