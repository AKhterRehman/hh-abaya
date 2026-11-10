@extends('layouts.admin')

@section('title', 'Orders Management')
@section('header_title', 'Customer Orders')

@section('content')

<div class="space-y-6">
    
    <!-- Status Filter Tabs -->
    <div class="flex flex-wrap gap-2 text-xs font-semibold">
        <a href="{{ route('admin.orders.index') }}" 
           class="px-4 py-2 rounded-xl transition border {{ !request('status') ? 'bg-[#231F20] text-white border-[#231F20] shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            All Orders ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-xl transition border {{ request('status') === 'pending' ? 'bg-amber-500 text-stone-900 border-amber-500 font-bold shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            Pending ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" 
           class="px-4 py-2 rounded-xl transition border {{ request('status') === 'processing' ? 'bg-blue-600 text-white border-blue-600 shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            Tailoring / Processing ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" 
           class="px-4 py-2 rounded-xl transition border {{ request('status') === 'shipped' ? 'bg-indigo-600 text-white border-indigo-600 shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            Shipped ({{ $statusCounts['shipped'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" 
           class="px-4 py-2 rounded-xl transition border {{ request('status') === 'delivered' ? 'bg-emerald-600 text-white border-emerald-600 shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            Delivered ({{ $statusCounts['delivered'] }})
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}" 
           class="px-4 py-2 rounded-xl transition border {{ request('status') === 'cancelled' ? 'bg-rose-600 text-white border-rose-600 shadow' : 'bg-white text-stone-600 border-stone-200 hover:bg-stone-50' }}">
            Cancelled ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <!-- Search Box -->
    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by Order #, customer name, phone number, city..." 
                       class="w-full pl-9 pr-3 py-2 bg-[#FAF7F2] rounded-xl border border-stone-200 text-xs focus:ring-1 focus:ring-[#C5A059]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
            </div>
            <button type="submit" class="px-5 py-2 bg-[#231F20] text-white rounded-xl text-xs font-semibold uppercase tracking-wider hover:bg-[#8C6D68] transition">
                Search
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Order #</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Customer</th>
                        <th class="py-3 px-4">Destination</th>
                        <th class="py-3 px-4">Payment</th>
                        <th class="py-3 px-4">Total</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="font-mono font-bold text-stone-900 hover:text-[#C5A059] block">
                                    {{ $order->order_number }}
                                </a>
                                @if($order->tracking_number)
                                    <span class="text-[10px] text-indigo-700 font-mono block">
                                        <i class="fa-solid fa-truck text-[9px]"></i> {{ $order->tracking_number }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-stone-500 whitespace-nowrap">
                                {{ $order->created_at->format('M d, Y') }}
                                <span class="text-[10px] block text-stone-400">{{ $order->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="py-3 px-4">
                                <span class="font-bold text-stone-900 block">{{ $order->customer_name }}</span>
                                <span class="text-[10px] text-stone-500 block font-mono">{{ $order->customer_phone }}</span>
                            </td>

                            <td class="py-3 px-4 text-stone-600">
                                <span class="font-semibold block text-stone-800">{{ $order->city }}</span>
                                <span class="text-[10px] text-stone-400 truncate max-w-xs block">{{ $order->shipping_address }}</span>
                            </td>

                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->payment_badge_class }} border block w-fit mb-0.5">
                                    {{ $order->payment_status }}
                                </span>
                                <span class="text-[10px] text-stone-500">{{ strtoupper($order->payment_method) }}</span>
                            </td>

                            <td class="py-3 px-4 font-bold text-[#8C6D68] whitespace-nowrap">
                                PKR {{ number_format($order->total) }}
                            </td>

                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $order->status_badge_class }} border block w-fit">
                                    {{ $order->order_status }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="p-1.5 text-stone-500 hover:text-stone-800 transition" title="Print Invoice / Packing Slip">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1 bg-stone-100 hover:bg-[#C5A059] hover:text-white rounded-lg transition font-semibold text-xs inline-block">
                                    Manage &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-12 text-stone-400">
                                No orders matching this filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $orders->links() }}
        </div>
    </div>

</div>

@endsection
