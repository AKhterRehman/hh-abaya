@extends('layouts.app')

@section('title', 'My Account | H&H Abaya Collection')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-8 border-b border-stone-200 gap-4">
        <div>
            <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Client Dashboard</span>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900">Welcome, {{ $user->name }}</h1>
            <p class="text-xs text-stone-500">{{ $user->email }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-5 py-2 bg-stone-100 hover:bg-rose-50 text-stone-700 hover:text-rose-600 rounded-xl text-xs font-semibold transition border border-stone-200">
                <i class="fa-solid fa-arrow-right-from-bracket mr-1.5"></i> Sign Out
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Profile & Shipping Address (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-200">
                    Profile & Default Address
                </h3>

                <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-[11px] font-semibold text-stone-700 block mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs focus:ring-1 focus:ring-[#C5A059]">
                    </div>

                    <div>
                        <label class="text-[11px] font-semibold text-stone-700 block mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0300 1234567" class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs focus:ring-1 focus:ring-[#C5A059]">
                    </div>

                    <div>
                        <label class="text-[11px] font-semibold text-stone-700 block mb-1">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}" placeholder="Karachi" class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs focus:ring-1 focus:ring-[#C5A059]">
                    </div>

                    <div>
                        <label class="text-[11px] font-semibold text-stone-700 block mb-1">Default Shipping Address</label>
                        <textarea name="address" rows="2" placeholder="House/Flat number, Street, Area..." class="w-full px-3 py-2 rounded-lg border border-stone-300 text-xs focus:ring-1 focus:ring-[#C5A059]">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- Orders History (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-200">
                    Your Order History
                </h3>

                @if($orders->count() > 0)
                    <div class="divide-y divide-stone-100">
                        @foreach($orders as $ord)
                            <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-3">
                                        <h4 class="font-mono text-sm font-bold text-stone-900">{{ $ord->order_number }}</h4>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $ord->status_badge_class }} border">
                                            {{ $ord->order_status }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-stone-500 mt-1">
                                        {{ $ord->created_at->format('M d, Y') }} &bull; {{ $ord->items->count() }} item(s) &bull; {{ $ord->payment_method_label }}
                                    </p>
                                    @if($ord->tracking_number)
                                        <p class="text-[11px] text-indigo-700 font-semibold mt-0.5">
                                            <i class="fa-solid fa-truck-fast mr-1"></i> Courier Tracking: {{ $ord->tracking_number }}
                                        </p>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between sm:justify-end gap-4">
                                    <span class="text-sm font-bold text-[#8C6D68]">
                                        PKR {{ number_format($ord->total) }}
                                    </span>
                                    <a href="{{ route('account.order-detail', $ord->order_number) }}" 
                                       class="px-3.5 py-1.5 bg-[#FAF7F2] hover:bg-[#E8DDD7] text-stone-800 text-xs font-semibold rounded-lg transition border border-stone-200">
                                        View Details &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-12 text-stone-500 space-y-3">
                        <i class="fa-solid fa-box-open text-3xl text-stone-300"></i>
                        <p class="text-xs">You have not placed any orders yet.</p>
                        <a href="{{ route('shop.index') }}" class="inline-block px-6 py-2.5 bg-[#231F20] text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:bg-[#8C6D68] transition">
                            Explore Collections
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection
