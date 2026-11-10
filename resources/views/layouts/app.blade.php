<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'H&H Abaya Collection | Modern Modesty, Timeless Grace')</title>
    <meta name="description" content="@yield('meta_description', 'Discover handcrafted luxury abayas, French khimars, 3-piece jilbabs and modest wear tailored from pure Dubai Nidha and Korean Georgette.')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                            50: '#FBF8F1',
                            100: '#F5EDDC',
                            200: '#EBD8B3',
                            300: '#DFC28B',
                            400: '#D4AD63',
                            500: '#C5A059',
                            600: '#A9833D',
                            700: '#86642A',
                            800: '#64481C',
                            900: '#422D0F',
                        },
                        rose: {
                            50: '#FBF9F8',
                            100: '#F6F0ED',
                            200: '#ECE0DB',
                            300: '#DDC9C2',
                            400: '#B8978E',
                            500: '#8C6D68',
                            600: '#735551',
                            700: '#593F3C',
                            800: '#422B29',
                            900: '#2A1817',
                        },
                        cream: '#FAF7F2',
                        sand: '#F3EFEB',
                        charcoal: '#231F20',
                        espresso: '#1A1615',
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
        
        /* ===== GOLD SHIMMER TEXT ===== */
        .gold-shimmer {
            background: linear-gradient(135deg, #C5A059 0%, #EBD8B3 50%, #C5A059 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer-flow 4s ease-in-out infinite;
        }
        @keyframes shimmer-flow {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .gold-border-gradient {
            border-image: linear-gradient(to right, #C5A059, #EBD8B3, #C5A059) 1;
        }

        /* ===== SCROLL-REVEAL ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.92); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .animate-fade-in-up { animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .animate-fade-in-left { animation: fadeInLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .animate-fade-in-right { animation: fadeInRight 0.8s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .animate-scale-in { animation: scaleIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .animate-float { animation: float 4s ease-in-out infinite; }

        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.9s cubic-bezier(0.22, 1, 0.36, 1); }
        .reveal.revealed { opacity: 1; transform: translateY(0); }
        .reveal-left { opacity: 0; transform: translateX(-30px); transition: all 0.9s cubic-bezier(0.22, 1, 0.36, 1); }
        .reveal-left.revealed { opacity: 1; transform: translateX(0); }
        .reveal-right { opacity: 0; transform: translateX(30px); transition: all 0.9s cubic-bezier(0.22, 1, 0.36, 1); }
        .reveal-right.revealed { opacity: 1; transform: translateX(0); }

        /* Staggered children animation */
        .stagger-children > * { opacity: 0; transform: translateY(20px); transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1); }
        .stagger-children.revealed > *:nth-child(1) { transition-delay: 0.05s; }
        .stagger-children.revealed > *:nth-child(2) { transition-delay: 0.12s; }
        .stagger-children.revealed > *:nth-child(3) { transition-delay: 0.19s; }
        .stagger-children.revealed > *:nth-child(4) { transition-delay: 0.26s; }
        .stagger-children.revealed > *:nth-child(5) { transition-delay: 0.33s; }
        .stagger-children.revealed > *:nth-child(6) { transition-delay: 0.40s; }
        .stagger-children.revealed > * { opacity: 1; transform: translateY(0); }

        /* ===== PREMIUM BUTTON EFFECTS ===== */
        .btn-gold-shimmer {
            position: relative;
            overflow: hidden;
        }
        .btn-gold-shimmer::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%);
            transition: left 0.6s ease;
        }
        .btn-gold-shimmer:hover::before { left: 100%; }

        /* ===== PREMIUM NAV UNDERLINE ===== */
        .nav-link-premium { position: relative; }
        .nav-link-premium::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #C5A059, #EBD8B3);
            transition: width 0.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .nav-link-premium:hover::after,
        .nav-link-premium.active::after { width: 100%; }

        /* ===== SUBTLE ISLAMIC GEOMETRIC PATTERN ===== */
        .islamic-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C5A059' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ===== ORNAMENTAL SECTION DIVIDER ===== */
        .ornament-divider {
            display: flex;
            align-items: center;
            gap: 16px;
            width: 100%;
        }
        .ornament-divider::before,
        .ornament-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #C5A059, transparent);
        }
        .ornament-divider .ornament-icon {
            color: #C5A059;
            font-size: 12px;
        }

        /* ===== IMAGE HOVER ZOOM + OVERLAY ===== */
        .img-zoom-hover { overflow: hidden; }
        .img-zoom-hover img {
            transition: transform 0.7s cubic-bezier(0.22, 1, 0.36, 1), filter 0.5s ease;
        }
        .img-zoom-hover:hover img {
            transform: scale(1.08);
        }

        /* ===== CARD HOVER ELEVATION ===== */
        .card-hover-lift {
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.4s ease;
        }
        .card-hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -8px rgba(35, 31, 32, 0.12), 0 8px 16px -4px rgba(197, 160, 89, 0.08);
        }

        /* ===== SOCIAL ICON HOVER ===== */
        .social-icon-hover {
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .social-icon-hover:hover {
            transform: translateY(-3px) scale(1.1);
        }

        /* ===== LOADING SKELETON ===== */
        @keyframes skeleton-pulse {
            0%, 100% { opacity: 0.4; }
            50% { opacity: 0.8; }
        }
        .skeleton { animation: skeleton-pulse 1.8s ease-in-out infinite; background: linear-gradient(90deg, #E8DDD7 25%, #F3EFEB 50%, #E8DDD7 75%); background-size: 200% 100%; }

        /* ===== SMOOTH PAGE LOAD ===== */
        body { animation: fadeInUp 0.5s ease-out both; }

        /* ===== Custom Scrollbar ===== */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #FAF7F2; }
        ::-webkit-scrollbar-thumb { background: #DDC9C2; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #C5A059; }

        /* ===== MOBILE RESPONSIVE FIXES ===== */
        @media (max-width: 480px) {
            .font-serif { letter-spacing: -0.01em; }
            h1 { font-size: 1.75rem !important; line-height: 1.2 !important; }
            h2 { font-size: 1.35rem !important; }
        }
        @media (max-width: 768px) {
            .mobile-full-bleed { margin-left: -1rem; margin-right: -1rem; border-radius: 0; }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#FAF7F2] text-[#231F20] font-sans antialiased selection:bg-[#C5A059] selection:text-white"
      x-data="globalStore()"
      x-init="initCart()">

    <!-- 1. Announcement Bar -->
    <div class="bg-[#231F20] text-amber-100 text-xs py-2 px-4 border-b border-[#C5A059]/30">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-[#C5A059] animate-pulse"></span>
                <span class="tracking-wide">
                    {{ \App\Models\Setting::get('announcement_text', '✨ FREE Delivery across Pakistan on orders above PKR 5,000 | Worldwide Shipping Available ✨') }}
                </span>
            </div>
            <div class="flex items-center gap-4 text-xs font-medium">
                <a href="{{ route('tracking.index') }}" class="hover:text-[#C5A059] transition-colors flex items-center gap-1">
                    <i class="fa-solid fa-truck-fast text-[11px]"></i> Track Order
                </a>
                <span class="text-stone-600">|</span>
                <a href="https://wa.me/{{ \App\Models\Setting::get('store_whatsapp', '923001234567') }}?text=Assalam%20o%20Alaikum%20H%26H%20Abaya" 
                   target="_blank" 
                   class="hover:text-emerald-400 transition-colors flex items-center gap-1">
                    <i class="fa-brands fa-whatsapp text-emerald-400 text-sm"></i> WhatsApp Support
                </a>
                <span class="text-stone-600">|</span>
                <span class="text-[#C5A059] font-semibold">PKR (Rs.)</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Luxury Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#E8DDD7] transition-all duration-300 shadow-sm"
            :class="{ 'shadow-md': scrolled }"
            @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" 
                            @click="mobileMenuOpen = true" 
                            class="p-2 text-stone-700 hover:text-[#C5A059] transition-colors"
                            aria-label="Open mobile menu">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <button type="button" 
                            @click="searchModalOpen = true" 
                            class="p-2 ml-1 text-stone-700 hover:text-[#C5A059] transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                </div>

                <!-- Left Navigation (Desktop) -->
                <nav class="hidden lg:flex items-center space-x-7 text-xs font-medium uppercase tracking-widest text-[#362C2A]">
                    <a href="{{ route('home') }}" class="hover:text-[#C5A059] transition-colors py-2 relative group {{ request()->routeIs('home') ? 'text-[#C5A059]' : '' }}">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#C5A059] transition-all group-hover:w-full {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                    </a>
                    <a href="{{ route('shop.index') }}" class="hover:text-[#C5A059] transition-colors py-2 relative group {{ request()->routeIs('shop.index') && !request('category') ? 'text-[#C5A059]' : '' }}">
                        All Abayas
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#C5A059] transition-all group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'luxury-front-open']) }}" class="hover:text-[#C5A059] transition-colors py-2 relative group">
                        Luxury Edit
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#C5A059] transition-all group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'khimar-sets']) }}" class="hover:text-[#C5A059] transition-colors py-2 relative group">
                        Khimar Sets
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#C5A059] transition-all group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'the-umrah-edit']) }}" class="hover:text-[#C5A059] transition-colors py-2 relative group">
                        The Umrah Edit
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#C5A059] transition-all group-hover:w-full"></span>
                    </a>
                </nav>

                <!-- Brand Logo (Center) -->
                <div class="flex-shrink-0 text-center flex flex-col items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.jpg') }}" 
                             alt="H&H Abaya Collection" 
                             class="h-14 sm:h-16 w-auto object-contain rounded-full shadow-sm ring-1 ring-[#C5A059]/40 group-hover:scale-105 transition-transform duration-300">
                        <div class="text-left hidden sm:block">
                            <span class="block font-serif text-lg font-bold tracking-wider text-[#231F20] group-hover:text-[#C5A059] transition-colors leading-tight">
                                H&H ABAYA
                            </span>
                            <span class="block text-[9px] uppercase tracking-[0.25em] text-[#8C6D68] font-semibold">
                                C O L L E C T I O N
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Right Actions (Desktop & Mobile) -->
                <div class="flex items-center space-x-3 sm:space-x-5 text-stone-700">
                    <!-- Search Button (Desktop) -->
                    <button type="button" 
                            @click="searchModalOpen = true" 
                            class="hidden lg:flex items-center gap-2 text-xs uppercase tracking-wider text-stone-600 hover:text-[#C5A059] transition-colors p-2">
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                        <span class="hidden xl:inline text-[11px]">Search</span>
                    </button>

                    <!-- Size Guide Link -->
                    <a href="{{ route('pages.size-guide') }}" 
                       class="hidden md:flex items-center gap-1 text-xs uppercase tracking-wider text-stone-600 hover:text-[#C5A059] transition-colors p-2"
                       title="View Abaya Size & Length Guide">
                        <i class="fa-solid fa-ruler-combined text-sm"></i>
                        <span class="hidden xl:inline text-[11px]">Size Guide</span>
                    </a>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" 
                       class="relative p-2 text-stone-700 hover:text-[#C5A059] transition-colors"
                       title="Your Wishlist">
                        <i class="fa-regular fa-heart text-lg"></i>
                        <span x-show="wishlistCount > 0" 
                              x-text="wishlistCount" 
                              class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-[10px] font-bold text-white bg-[#8C6D68] rounded-full"
                              x-cloak>
                        </span>
                    </a>

                    <!-- Account / User Dropdown -->
                    <div class="relative" x-data="{ userMenuOpen: false }">
                        <button type="button" 
                                @click="userMenuOpen = !userMenuOpen" 
                                @click.outside="userMenuOpen = false"
                                class="p-2 text-stone-700 hover:text-[#C5A059] transition-colors"
                                title="My Account">
                            <i class="fa-regular fa-user text-lg"></i>
                        </button>

                        <div x-show="userMenuOpen" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-xl border border-[#E8DDD7] py-2 z-50 text-xs"
                             x-cloak>
                            @auth
                                <div class="px-4 py-2 border-b border-stone-100">
                                    <p class="font-semibold text-stone-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-stone-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-amber-700 hover:bg-amber-50 font-medium">
                                        <i class="fa-solid fa-gauge-high mr-2 text-amber-600"></i> Admin Portal
                                    </a>
                                @endif
                                <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-stone-700 hover:bg-[#FAF7F2]">
                                    <i class="fa-solid fa-bag-shopping mr-2 text-[#C5A059]"></i> My Orders
                                </a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50">
                                        <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
                                    </button>
                                </form>
                            @else
                                <div class="px-4 py-2 text-center border-b border-stone-100">
                                    <p class="font-semibold text-stone-800">Welcome to H&H</p>
                                    <p class="text-[11px] text-stone-500">Access your orders & saved items</p>
                                </div>
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-stone-800 hover:bg-[#FAF7F2] font-semibold">
                                    <i class="fa-solid fa-right-to-bracket mr-2 text-[#C5A059]"></i> Sign In
                                </a>
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-stone-600 hover:bg-[#FAF7F2]">
                                    <i class="fa-solid fa-user-plus mr-2 text-[#8C6D68]"></i> Create Account
                                </a>
                                <div class="border-t border-stone-100 my-1"></div>
                                <a href="{{ route('admin.login') }}" class="block px-4 py-1.5 text-stone-400 hover:text-stone-700 text-[11px]">
                                    <i class="fa-solid fa-lock mr-2"></i> Admin Login
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Slide-over Cart Trigger Button -->
                    <button type="button" 
                            @click="cartDrawerOpen = true" 
                            class="relative p-2.5 bg-[#8C6D68] text-white hover:bg-[#735551] rounded-full transition-all duration-200 shadow-sm flex items-center justify-center"
                            title="Shopping Bag">
                        <i class="fa-solid fa-bag-shopping text-sm"></i>
                        <span x-show="cartData.itemsCount > 0" 
                              x-text="cartData.itemsCount" 
                              class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-[#C5A059] rounded-full ring-2 ring-white"
                              x-cloak>
                        </span>
                    </button>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Slide-out Navigation Drawer -->
    <div x-show="mobileMenuOpen" 
         class="fixed inset-0 z-50 lg:hidden" 
         x-cloak>
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" 
             @click="mobileMenuOpen = false"></div>
        <div class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-2xl flex flex-col z-10 transition-transform">
            <div class="p-5 flex items-center justify-between border-b border-[#E8DDD7] bg-[#FAF7F2]">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="h-10 w-10 rounded-full object-cover ring-1 ring-[#C5A059]">
                    <span class="font-serif font-bold text-sm text-[#231F20]">H&H ABAYA</span>
                </div>
                <button type="button" @click="mobileMenuOpen = false" class="text-stone-500 hover:text-stone-800 p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <div class="p-4 flex-1 overflow-y-auto space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    Home
                </a>
                <a href="{{ route('shop.index') }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    All Abayas & Khimars
                </a>
                <a href="{{ route('shop.index', ['category' => 'luxury-front-open']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    Luxury Front Open
                </a>
                <a href="{{ route('shop.index', ['category' => 'everyday-abayas']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    Everyday Minimalist
                </a>
                <a href="{{ route('shop.index', ['category' => 'khimar-sets']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    Khimar Sets & Combos
                </a>
                <a href="{{ route('shop.index', ['category' => '3-piece-jilbabs']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    3-Piece Jilbabs & Niqabs
                </a>
                <a href="{{ route('shop.index', ['category' => 'the-umrah-edit']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    The Umrah Edit
                </a>
                <a href="{{ route('shop.index', ['category' => 'namaz-chadars-hijabs']) }}" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-stone-800 hover:bg-[#FAF7F2] hover:text-[#C5A059]">
                    Namaz Chadars & Hijabs
                </a>

                <div class="border-t border-[#E8DDD7] my-3 pt-3">
                    <a href="{{ route('pages.size-guide') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-stone-700 hover:bg-[#FAF7F2]">
                        <i class="fa-solid fa-ruler-combined text-[#C5A059]"></i> Size & Length Guide
                    </a>
                    <a href="{{ route('tracking.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-stone-700 hover:bg-[#FAF7F2]">
                        <i class="fa-solid fa-truck-fast text-[#C5A059]"></i> Track My Order
                    </a>
                    <a href="{{ route('pages.about') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-stone-700 hover:bg-[#FAF7F2]">
                        <i class="fa-solid fa-feather text-[#C5A059]"></i> Our Story & Craft
                    </a>
                    <a href="{{ route('pages.contact') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-stone-700 hover:bg-[#FAF7F2]">
                        <i class="fa-solid fa-envelope text-[#C5A059]"></i> Contact Concierge
                    </a>
                </div>
            </div>

            <div class="p-4 border-t border-[#E8DDD7] bg-[#FAF7F2]">
                <a href="https://wa.me/{{ \App\Models\Setting::get('store_whatsapp', '923001234567') }}" 
                   target="_blank" 
                   class="w-full flex items-center justify-center gap-2 py-2.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold tracking-wider uppercase shadow hover:bg-emerald-700 transition">
                    <i class="fa-brands fa-whatsapp text-base"></i> Chat on WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Search Modal -->
    <div x-show="searchModalOpen" 
         class="fixed inset-0 z-50 flex items-start justify-center pt-20 px-4 sm:px-6"
         x-cloak>
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" @click="searchModalOpen = false"></div>
        <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-[#E8DDD7] p-6 z-10"
             @keydown.escape.window="searchModalOpen = false">
            <div class="flex items-center justify-between pb-4 border-b border-stone-100">
                <span class="font-serif text-lg font-semibold text-stone-900">Search H&H Abaya</span>
                <button type="button" @click="searchModalOpen = false" class="text-stone-400 hover:text-stone-700">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <form action="{{ route('shop.index') }}" method="GET" class="mt-4">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           placeholder="Search by abaya name, color, fabric (e.g. Dubai Nidha, Khimar, Umrah)..." 
                           class="w-full pl-12 pr-4 py-3.5 bg-[#FAF7F2] rounded-xl border border-[#E8DDD7] focus:outline-none focus:ring-2 focus:ring-[#C5A059] focus:bg-white text-sm"
                           autofocus>
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 text-base"></i>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <div class="flex flex-wrap gap-2 text-xs">
                        <span class="text-stone-400">Popular:</span>
                        <a href="{{ route('shop.index', ['search' => 'Nidha']) }}" class="px-2.5 py-1 bg-stone-100 rounded-full hover:bg-[#C5A059] hover:text-white transition">Nidha</a>
                        <a href="{{ route('shop.index', ['search' => 'Khimar']) }}" class="px-2.5 py-1 bg-stone-100 rounded-full hover:bg-[#C5A059] hover:text-white transition">Khimar</a>
                        <a href="{{ route('shop.index', ['search' => 'Umrah']) }}" class="px-2.5 py-1 bg-stone-100 rounded-full hover:bg-[#C5A059] hover:text-white transition">Umrah</a>
                        <a href="{{ route('shop.index', ['search' => 'Front Open']) }}" class="px-2.5 py-1 bg-stone-100 rounded-full hover:bg-[#C5A059] hover:text-white transition">Front Open</a>
                    </div>
                    <button type="submit" class="px-5 py-2 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-semibold uppercase tracking-wider rounded-lg transition">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Flash Messages (Session) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-4 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-amber-600 text-lg"></i>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-500 hover:text-amber-800">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Slide-over Cart Drawer Component -->
    @include('components.cart-drawer')

    <!-- Quick View Modal Component -->
    @include('components.quick-view-modal')

    <!-- Size Guide Modal Component -->
    @include('components.size-guide-modal')

    <!-- Toast Notification Popup -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-[#231F20] text-white rounded-xl shadow-2xl p-4 border border-[#C5A059]/40 flex items-start gap-3"
         x-cloak>
        <div class="w-8 h-8 rounded-full bg-[#C5A059]/20 text-[#C5A059] flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="fa-solid fa-check text-sm"></i>
        </div>
        <div class="flex-1">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-[#C5A059]" x-text="toast.title || 'Shopping Bag Updated'"></h4>
            <p class="text-xs text-stone-300 mt-0.5" x-text="toast.message"></p>
        </div>
        <button type="button" @click="toast.show = false" class="text-stone-400 hover:text-white">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Floating WhatsApp Concierge Button -->
    <a href="https://wa.me/{{ \App\Models\Setting::get('store_whatsapp', '923001234567') }}?text=Assalam%20o%20Alaikum!%20I%20have%20an%20inquiry%20regarding%20H%26H%20Abaya%20Collection." 
       target="_blank" 
       class="fixed bottom-6 left-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 group ring-4 ring-emerald-500/20"
       title="Direct WhatsApp Concierge">
        <i class="fa-brands fa-whatsapp text-2xl group-hover:rotate-12 transition-transform"></i>
        <span class="absolute left-16 bg-[#231F20] text-white text-xs px-3 py-1.5 rounded-lg whitespace-nowrap shadow-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity border border-[#C5A059]/30">
            Need styling advice? Chat on WhatsApp
        </span>
    </a>

    <!-- Footer -->
    <footer class="bg-[#1A1615] text-[#FAF7F2] border-t-2 border-[#C5A059] pt-16 pb-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-stone-800">
                
                <!-- Brand Col -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya" class="h-14 w-14 rounded-full ring-2 ring-[#C5A059]">
                        <div>
                            <span class="font-serif text-xl font-bold tracking-wider text-white">H&H ABAYA</span>
                            <span class="block text-[10px] tracking-[0.3em] uppercase text-[#C5A059]">COLLECTION</span>
                        </div>
                    </div>
                    <p class="text-xs text-stone-400 leading-relaxed max-w-sm">
                        {{ \App\Models\Setting::get('about_story', 'Modern Modesty, Timeless Grace. Handcrafted luxury abayas, French khimars, and modest wear tailored from original Dubai Nidha.') }}
                    </p>
                    <div class="flex items-center space-x-3 pt-2">
                        <a href="{{ \App\Models\Setting::get('instagram_url', 'https://instagram.com') }}" target="_blank" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-[#C5A059] hover:text-white flex items-center justify-center text-stone-400 transition-colors">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="{{ \App\Models\Setting::get('facebook_url', 'https://facebook.com') }}" target="_blank" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-[#C5A059] hover:text-white flex items-center justify-center text-stone-400 transition-colors">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/{{ \App\Models\Setting::get('store_whatsapp', '923001234567') }}" target="_blank" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-stone-400 transition-colors">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Collections Col -->
                <div>
                    <h4 class="font-serif text-sm font-semibold tracking-wider uppercase text-[#C5A059] mb-4">Collections</h4>
                    <ul class="space-y-2.5 text-xs text-stone-400">
                        <li><a href="{{ route('shop.index', ['category' => 'everyday-abayas']) }}" class="hover:text-white transition">Everyday Abayas</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'luxury-front-open']) }}" class="hover:text-white transition">Luxury Front Open</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'khimar-sets']) }}" class="hover:text-white transition">French Khimar Sets</a></li>
                        <li><a href="{{ route('shop.index', ['category' => '3-piece-jilbabs']) }}" class="hover:text-white transition">3-Piece Jilbabs</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'the-umrah-edit']) }}" class="hover:text-white transition">The Umrah Edit</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'namaz-chadars-hijabs']) }}" class="hover:text-white transition">Namaz Chadars</a></li>
                    </ul>
                </div>

                <!-- Customer Care Col -->
                <div>
                    <h4 class="font-serif text-sm font-semibold tracking-wider uppercase text-[#C5A059] mb-4">Customer Care</h4>
                    <ul class="space-y-2.5 text-xs text-stone-400">
                        <li><a href="{{ route('pages.size-guide') }}" class="hover:text-white transition">Size & Length Guide</a></li>
                        <li><a href="{{ route('tracking.index') }}" class="hover:text-white transition">Track Your Order</a></li>
                        <li><a href="{{ route('pages.shipping') }}" class="hover:text-white transition">Shipping & Return Policy</a></li>
                        <li><a href="{{ route('pages.faqs') }}" class="hover:text-white transition">Frequently Asked Questions</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-[#C5A059] transition text-stone-500">Admin Portal</a></li>
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div>
                    <h4 class="font-serif text-sm font-semibold tracking-wider uppercase text-[#C5A059] mb-4">Get in Touch</h4>
                    <ul class="space-y-2.5 text-xs text-stone-400 mb-5">
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-[#C5A059] mt-0.5"></i>
                            <span>{{ \App\Models\Setting::get('store_address', 'DHA Phase 5, Karachi, Pakistan') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-[#C5A059]"></i>
                            <span>{{ \App\Models\Setting::get('store_phone', '+92 300 1234567') }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-[#C5A059]"></i>
                            <span>{{ \App\Models\Setting::get('store_email', 'info@hhabaya.com') }}</span>
                        </li>
                    </ul>

                    <div class="bg-stone-900/80 p-3 rounded-lg border border-stone-800">
                        <p class="text-[11px] text-stone-300 mb-2 font-medium">✨ Use code <span class="text-[#C5A059] font-bold">WELCOME10</span> for 10% OFF your first order!</p>
                    </div>
                </div>

            </div>

            <!-- Bottom Row: Copyright & Payment Icons -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-stone-500 gap-4">
                <p>&copy; {{ date('Y') }} H&H Abaya Collection. All Rights Reserved. Crafted with reverence.</p>
                <div class="flex items-center space-x-3 text-lg text-stone-400">
                    <span class="text-[11px] uppercase tracking-wider text-stone-500 mr-2">Payment Methods:</span>
                    <span class="px-2 py-1 bg-stone-900 border border-stone-800 rounded text-[11px] font-semibold text-emerald-400">Cash on Delivery</span>
                    <span class="px-2 py-1 bg-stone-900 border border-stone-800 rounded text-[11px] font-semibold text-amber-300">Bank Transfer</span>
                    <i class="fa-brands fa-cc-visa text-blue-400 text-xl"></i>
                    <i class="fa-brands fa-cc-mastercard text-rose-400 text-xl"></i>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Store & Scripts -->
    <script>
        function globalStore() {
            return {
                mobileMenuOpen: false,
                searchModalOpen: false,
                cartDrawerOpen: false,
                sizeGuideModalOpen: false,
                quickViewModalOpen: false,
                quickViewProduct: {},
                quickViewSize: '',
                quickViewLength: '',
                quickViewColor: '',
                quickViewQuantity: 1,
                quickViewImageIndex: 0,
                wishlistCount: 0,
                scrolled: false,
                cartData: {
                    cart: {},
                    subtotal: 0,
                    itemsCount: 0,
                    freeShippingMin: 5000,
                    freeShippingProgress: 0,
                    amountNeededForFreeShipping: 5000,
                    isFreeShipping: false,
                    shippingFee: 250,
                    discount: 0,
                    total: 0,
                },
                toast: {
                    show: false,
                    title: '',
                    message: '',
                    timeout: null,
                },

                triggerToast(title, message) {
                    this.toast.title = title;
                    this.toast.message = message;
                    this.toast.show = true;
                    if (this.toast.timeout) clearTimeout(this.toast.timeout);
                    this.toast.timeout = setTimeout(() => {
                        this.toast.show = false;
                    }, 4000);
                },

                initCart() {
                    fetch('{{ route("cart.drawer") }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.data) {
                            this.cartData = data.data;
                        }
                    })
                    .catch(e => console.error("Cart init error:", e));
                },

                addToCartAjax(productId, size, length, color, quantity = 1, showDrawer = true) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('{{ route("cart.add") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            size: size,
                            length: length,
                            color: color,
                            quantity: quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.cartData = data.data;
                            this.triggerToast('Added to Shopping Bag', data.message);
                            if (showDrawer) {
                                this.cartDrawerOpen = true;
                            }
                        }
                    })
                    .catch(e => {
                        console.error("Cart error:", e);
                        alert("Could not add to bag. Please try again.");
                    });
                },

                updateCartQuantity(key, quantity) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('{{ route("cart.update") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ key, quantity })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.cartData = data.data;
                        }
                    });
                },

                removeCartItem(key) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch('{{ route("cart.remove") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ key })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.cartData = data.data;
                            this.triggerToast('Bag Updated', 'Item removed from your bag.');
                        }
                    });
                },

                toggleWishlist(productId) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    fetch(`/wishlist/toggle/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.wishlistCount = data.count;
                            this.triggerToast(data.added ? 'Wishlist Added' : 'Wishlist Removed', data.message);
                        }
                    });
                },

                openQuickView(productId) {
                    fetch(`/api/quick-view/${productId}`)
                    .then(res => res.json())
                    .then(prod => {
                        this.quickViewProduct = prod;
                        this.quickViewSize = prod.sizes && prod.sizes.length ? prod.sizes[0] : 'M';
                        this.quickViewLength = prod.lengths && prod.lengths.length ? prod.lengths[0] : '54"';
                        this.quickViewColor = prod.colors && prod.colors.length ? prod.colors[0].name : '';
                        this.quickViewQuantity = 1;
                        this.quickViewImageIndex = 0;
                        this.quickViewModalOpen = true;
                    })
                    .catch(e => console.error("QuickView error:", e));
                }
            };
        }
    </script>

    @stack('scripts')

    <!-- Scroll-Reveal Intersection Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .stagger-children');
            if (revealElements.length === 0) return;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

            revealElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
