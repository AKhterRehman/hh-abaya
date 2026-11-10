<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | H&H Abaya Portal</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS with Luxury Brand Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: {
                            400: '#D4AD63',
                            500: '#C5A059',
                            600: '#A9833D',
                        },
                        rose: {
                            500: '#8C6D68',
                            600: '#735551',
                        },
                        dark: {
                            800: '#1F1B1A',
                            900: '#141211',
                        }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F8F6F3] text-stone-900 font-sans antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         class="fixed inset-0 bg-black/60 z-40 lg:hidden" 
         @click="sidebarOpen = false" 
         x-cloak></div>

    <!-- Admin Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#141211] text-stone-300 flex flex-col justify-between transition-transform duration-300 border-r border-stone-800 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
        
        <!-- Brand Header -->
        <div>
            <div class="p-6 border-b border-stone-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full ring-2 ring-[#C5A059]">
                    <div>
                        <span class="font-serif font-bold text-sm text-white tracking-wider block">H&H ABAYA</span>
                        <span class="text-[9px] uppercase tracking-[0.2em] text-[#C5A059] block">ADMIN PORTAL</span>
                    </div>
                </a>
                <button type="button" @click="sidebarOpen = false" class="lg:hidden text-stone-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-xs">
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-gauge-high w-4 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <div class="pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-stone-500 px-3">E-Commerce</div>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-boxes-packing w-4 text-center"></i>
                        <span>Orders</span>
                    </div>
                    @php $pendingCount = \App\Models\Order::where('order_status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-500 text-stone-900">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.products.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-vest w-4 text-center"></i>
                    <span>Products</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-layer-group w-4 text-center"></i>
                    <span>Categories</span>
                </a>

                <a href="{{ route('admin.coupons.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.coupons.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-ticket w-4 text-center"></i>
                    <span>Coupons & Promos</span>
                </a>

                <div class="pt-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-stone-500 px-3">Storefront</div>

                <a href="{{ route('admin.banners.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.banners.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-images w-4 text-center"></i>
                    <span>Hero Banners</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-star-half-stroke w-4 text-center"></i>
                    <span>Customer Reviews</span>
                </a>

                <a href="{{ route('admin.customers.index') }}" 
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.customers.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <i class="fa-solid fa-users w-4 text-center"></i>
                    <span>Customers</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center justify-between px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#C5A059] text-white font-bold shadow' : 'text-stone-300 hover:bg-stone-800/80 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-sliders w-4 text-center"></i>
                        <span>Settings & Inbox</span>
                    </div>
                    @php $msgCount = \App\Models\ContactMessage::where('is_read', false)->count(); @endphp
                    @if($msgCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-500 text-white">
                            {{ $msgCount }}
                        </span>
                    @endif
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-stone-800 space-y-2">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2 bg-stone-800/80 hover:bg-stone-700 text-stone-300 hover:text-white rounded-xl text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                <span>View Live Storefront</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2 bg-rose-950/40 hover:bg-rose-900/60 text-rose-300 rounded-xl text-xs font-semibold transition border border-rose-900/40">
                    <i class="fa-solid fa-power-off text-[11px]"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>

    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 lg:pl-64 flex flex-col min-h-screen">
        
        <!-- Top Navigation Bar -->
        <header class="sticky top-0 z-30 bg-white border-b border-stone-200 px-6 py-3.5 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <button type="button" @click="sidebarOpen = true" class="lg:hidden p-2 text-stone-600 hover:text-stone-900">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <h2 class="font-serif text-lg font-bold text-stone-900">
                    @yield('header_title', 'Admin Portal')
                </h2>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <span class="text-xs font-bold text-stone-900 block">{{ auth()->user()?->name ?? 'Administrator' }}</span>
                    <span class="text-[10px] text-stone-400 block">Store Manager</span>
                </div>
                <div class="w-9 h-9 rounded-full bg-[#C5A059] text-white flex items-center justify-center font-bold text-xs shadow">
                    {{ substr(auth()->user()?->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="p-6 pb-0">
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Page Body Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="p-6 border-t border-stone-200 text-center text-xs text-stone-400 bg-white">
            &copy; {{ date('Y') }} H&H Abaya Collection Admin Portal &bull; Enterprise Management System
        </footer>

    </div>

    @stack('scripts')
</body>
</html>
