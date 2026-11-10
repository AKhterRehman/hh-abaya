@extends('layouts.admin')

@section('title', 'Client Profile: ' . $customer->name)
@section('header_title', 'Client Profile')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.customers.index') }}" class="text-xs text-stone-500 hover:text-stone-800 flex items-center gap-1 font-semibold">
            <i class="fa-solid fa-arrow-left"></i> Back to Customers Directory
        </a>
    </div>

    <!-- Client Header Card -->
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="flex items-center gap-4 text-center sm:text-left">
            <div class="w-16 h-16 rounded-full bg-[#FAF7F2] text-[#8C6D68] border-2 border-[#C5A059] flex items-center justify-center font-bold text-2xl shadow-inner">
                {{ substr($customer->name, 0, 1) }}
            </div>
            <div>
                <h2 class="font-serif text-xl font-bold text-stone-900">{{ $customer->name }}</h2>
                <p class="text-xs text-stone-500">{{ $customer->email }} &bull; {{ $customer->phone ?? 'No phone' }}</p>
                <p class="text-xs text-stone-400 mt-0.5">Member since {{ $customer->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-6 text-center sm:text-right border-t sm:border-t-0 sm:border-l border-stone-100 pt-4 sm:pt-0 sm:pl-6">
            <div>
                <span class="text-[10px] uppercase font-bold text-stone-400 block tracking-wider">Total Orders</span>
                <span class="font-serif text-2xl font-bold text-stone-900">{{ $customer->orders->count() }}</span>
            </div>
            <div>
                <span class="text-[10px] uppercase font-bold text-stone-400 block tracking-wider">Total Delivered Spend</span>
                <span class="font-serif text-2xl font-bold text-[#8C6D68]">PKR {{ number_format($totalSpent) }}</span>
            </div>
        </div>
    </div>

    <!-- Orders Placed by Client -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden p-6 space-y-4">
        <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
            Order History
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-2.5 px-3">Order #</th>
                        <th class="py-2.5 px-3">Date</th>
                        <th class="py-2.5 px-3">Items</th>
                        <th class="py-2.5 px-3">Total</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($customer->orders as $order)
                        <tr class="hover:bg-stone-50">
                            <td class="py-3 px-3 font-mono font-bold text-stone-900">{{ $order->order_number }}</td>
                            <td class="py-3 px-3 text-stone-500">{{ $order->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-3 font-semibold text-stone-800">{{ $order->items->count() }} items</td>
                            <td class="py-3 px-3 font-bold text-[#8C6D68]">PKR {{ number_format($order->total) }}</td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status_badge_class }} border">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1 bg-stone-100 hover:bg-[#C5A059] hover:text-white rounded-lg transition font-semibold text-xs">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400">No orders placed by this customer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
