@extends('layouts.admin')

@section('title', 'Executive Overview')
@section('header_title', 'Dashboard Overview')

@section('content')

<div class="space-y-8">
    
    <!-- 1. KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">Total Revenue</span>
                <span class="font-serif text-2xl font-bold text-stone-900 mt-1 block">
                    PKR {{ number_format($totalRevenue) }}
                </span>
                <span class="text-[11px] text-emerald-600 font-semibold flex items-center gap-1 mt-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Live Store Sales
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">Total Orders</span>
                <span class="font-serif text-2xl font-bold text-stone-900 mt-1 block">
                    {{ $totalOrders }}
                </span>
                <span class="text-[11px] text-amber-600 font-semibold mt-1 block">
                    {{ $pendingOrders }} Pending Fulfillment
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-boxes-packing"></i>
            </div>
        </div>

        <!-- Active Products -->
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">Total Catalog</span>
                <span class="font-serif text-2xl font-bold text-stone-900 mt-1 block">
                    {{ $totalProducts }}
                </span>
                <span class="text-[11px] text-stone-500 mt-1 block">
                    {{ $lowStockCount > 0 ? $lowStockCount . ' Low in Stock' : 'Stock Optimal' }}
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-vest"></i>
            </div>
        </div>

        <!-- Registered Customers -->
        <div class="bg-white p-5 rounded-2xl border border-stone-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold uppercase tracking-wider text-stone-500 block">Registered Clients</span>
                <span class="font-serif text-2xl font-bold text-stone-900 mt-1 block">
                    {{ $totalCustomers }}
                </span>
                <span class="text-[11px] text-stone-500 mt-1 block">
                    {{ $unreadMessagesCount }} New Inquiries
                </span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

    </div>

    <!-- 2. Quick Action Shortcuts Bar -->
    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Quick Actions:</span>
        </div>
        <div class="flex flex-wrap gap-2.5 text-xs font-semibold">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-[#C5A059] hover:bg-[#A9833D] text-white rounded-xl transition shadow flex items-center gap-1.5">
                <i class="fa-solid fa-plus text-[10px]"></i>
                <span>Add New Abaya</span>
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 bg-[#231F20] hover:bg-[#8C6D68] text-white rounded-xl transition shadow flex items-center gap-1.5">
                <i class="fa-solid fa-truck-ramp-box text-[10px]"></i>
                <span>Process Pending Orders ({{ $pendingOrders }})</span>
            </a>
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-images text-[10px]"></i>
                <span>Edit Hero Banners</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 rounded-xl transition flex items-center gap-1.5">
                <i class="fa-solid fa-sliders text-[10px]"></i>
                <span>Store Settings</span>
            </a>
        </div>
    </div>

    <!-- 3. Recent Orders Table & Low Stock Alert -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Recent Orders (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-stone-200 p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-stone-100">
                <div>
                    <h3 class="font-serif text-base font-bold text-stone-900">Recent Customer Orders</h3>
                    <p class="text-[11px] text-stone-500">Latest orders placed on your storefront</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-[#8C6D68] hover:text-[#C5A059] transition">
                    View All Orders &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2.5 px-3">Order #</th>
                            <th class="py-2.5 px-3">Customer</th>
                            <th class="py-2.5 px-3">Total</th>
                            <th class="py-2.5 px-3">Payment</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-stone-50">
                                <td class="py-3 px-3 font-mono font-bold text-stone-900">{{ $order->order_number }}</td>
                                <td class="py-3 px-3">
                                    <span class="font-semibold block text-stone-800">{{ $order->customer_name }}</span>
                                    <span class="text-[10px] text-stone-400">{{ $order->city }}</span>
                                </td>
                                <td class="py-3 px-3 font-bold text-[#8C6D68]">PKR {{ number_format($order->total) }}</td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->payment_badge_class }} border">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status_badge_class }} border">
                                        {{ $order->order_status }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-2.5 py-1 bg-stone-100 hover:bg-[#C5A059] hover:text-white rounded-lg transition font-semibold text-[11px]">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-stone-400">No orders placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alerts & Top Products (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Low Stock Alert -->
            <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                    <h4 class="font-serif text-sm font-bold text-stone-900 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                        <span>Stock Alerts</span>
                    </h4>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded-full">
                        {{ $lowStockProducts->count() }} Items
                    </span>
                </div>

                <div class="divide-y divide-stone-100 text-xs">
                    @forelse($lowStockProducts as $lp)
                        <div class="py-2.5 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate max-w-[70%]">
                                <img src="{{ $lp->primary_image_url }}" class="w-8 h-10 object-cover rounded border border-stone-200 flex-shrink-0">
                                <span class="truncate font-semibold text-stone-800">{{ $lp->name }}</span>
                            </div>
                            <span class="font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-200 text-[10px]">
                                {{ $lp->stock }} left
                            </span>
                        </div>
                    @empty
                        <p class="text-stone-400 text-[11px] py-4 text-center">All product inventory levels are healthy.</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Selling / Popular Items -->
            <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-stone-100">
                    <h4 class="font-serif text-sm font-bold text-stone-900 flex items-center gap-2">
                        <i class="fa-solid fa-trophy text-[#C5A059]"></i>
                        <span>Popular Abayas</span>
                    </h4>
                </div>

                <div class="divide-y divide-stone-100 text-xs">
                    @foreach($topProducts as $tp)
                        <div class="py-2.5 flex items-center justify-between">
                            <div class="flex items-center gap-2.5 truncate max-w-[75%]">
                                <img src="{{ $tp->primary_image_url }}" class="w-8 h-10 object-cover rounded border border-stone-200 flex-shrink-0">
                                <div>
                                    <span class="truncate font-semibold text-stone-800 block">{{ $tp->name }}</span>
                                    <span class="text-[10px] text-stone-400">PKR {{ number_format($tp->effective_price) }}</span>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold text-amber-500">
                                ★ {{ number_format($tp->rating, 1) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
