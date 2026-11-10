@extends('layouts.admin')

@section('title', 'Registered Customers')
@section('header_title', 'Client Directory')

@section('content')

<div class="space-y-6">
    
    <!-- Search Box -->
    <div class="bg-white p-4 rounded-2xl border border-stone-200 shadow-sm">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="flex gap-3">
            <div class="relative flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by customer name, email, phone, city..." 
                       class="w-full pl-9 pr-3 py-2 bg-[#FAF7F2] rounded-xl border border-stone-200 text-xs focus:ring-1 focus:ring-[#C5A059]">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
            </div>
            <button type="submit" class="px-5 py-2 bg-[#231F20] text-white rounded-xl text-xs font-semibold uppercase tracking-wider hover:bg-[#8C6D68] transition">
                Search
            </button>
        </form>
    </div>

    <!-- Customers Table -->
    <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-stone-100 flex items-center justify-between">
            <h3 class="font-serif text-base font-bold text-stone-900">Registered Clients</h3>
            <span class="text-xs text-stone-500">{{ $customers->total() }} Total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-4">Client Name</th>
                        <th class="py-3 px-4">Contact Info</th>
                        <th class="py-3 px-4">Location</th>
                        <th class="py-3 px-4">Orders Count</th>
                        <th class="py-3 px-4">Joined On</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @forelse($customers as $client)
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-[#FAF7F2] text-[#8C6D68] border border-[#E8DDD7] flex items-center justify-center font-bold">
                                        {{ substr($client->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-stone-900 block">{{ $client->name }}</span>
                                        <span class="text-[10px] text-stone-400">ID: #{{ $client->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <span class="text-stone-800 block">{{ $client->email }}</span>
                                <span class="text-[10px] text-stone-500 font-mono">{{ $client->phone ?? 'No Phone' }}</span>
                            </td>

                            <td class="py-3 px-4 text-stone-600">
                                {{ $client->city ?? 'Not specified' }}
                            </td>

                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-[#FAF7F2] border border-stone-200 text-stone-800">
                                    {{ $client->orders_count }} orders
                                </span>
                            </td>

                            <td class="py-3 px-4 text-stone-400 whitespace-nowrap">
                                {{ $client->created_at->format('M d, Y') }}
                            </td>

                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('admin.customers.show', $client->id) }}" class="px-3 py-1 bg-stone-100 hover:bg-[#C5A059] hover:text-white rounded-lg transition font-semibold text-xs">
                                    View Profile &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-stone-400">No registered customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-stone-200">
            {{ $customers->links() }}
        </div>
    </div>

</div>

@endsection
