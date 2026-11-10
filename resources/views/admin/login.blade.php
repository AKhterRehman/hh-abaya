<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | H&H Abaya Collection</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#141211] text-stone-200 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-[#1F1B1A] rounded-3xl border border-stone-800 p-8 sm:p-10 shadow-2xl space-y-6">
        
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya" class="w-16 h-16 rounded-full mx-auto ring-2 ring-[#C5A059] shadow-lg">
            <h1 class="font-serif text-2xl font-bold text-white tracking-wide">H&H Admin Portal</h1>
            <p class="text-xs text-stone-400">Enter your administrative credentials to continue</p>
        </div>

        @if(session('error'))
            <div class="p-3.5 rounded-xl bg-rose-950/40 border border-rose-800 text-rose-300 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="p-3.5 rounded-xl bg-emerald-950/40 border border-emerald-800 text-emerald-300 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs font-semibold text-stone-300 block mb-1">Admin Email</label>
                <div class="relative">
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', 'admin@hh-abaya.com') }}" 
                           required 
                           class="w-full pl-10 pr-4 py-3 bg-stone-900 rounded-xl border border-stone-700 text-xs text-white focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
                    <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-500 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-300 block mb-1">Password</label>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           value="password123"
                           required 
                           class="w-full pl-10 pr-4 py-3 bg-stone-900 rounded-xl border border-stone-700 text-xs text-white focus:outline-none focus:ring-2 focus:ring-[#C5A059]">
                    <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-500 text-xs"></i>
                </div>
            </div>

            <div class="flex items-center justify-between text-xs text-stone-400">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" checked class="rounded bg-stone-900 border-stone-700 text-[#C5A059] focus:ring-[#C5A059]">
                    <span>Keep me logged in</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-lg flex items-center justify-center gap-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Sign In to Dashboard</span>
            </button>
        </form>

        <!-- Credentials Helper Note -->
        <div class="p-3 bg-stone-900/80 rounded-xl border border-stone-800 text-[11px] text-stone-400 text-center space-y-1">
            <span class="text-amber-300 font-semibold block">Default Admin Credentials:</span>
            <span>Email: <strong>admin@hh-abaya.com</strong> | Password: <strong>password123</strong></span>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-xs text-stone-500 hover:text-stone-300 transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Return to Storefront</span>
            </a>
        </div>

    </div>

</body>
</html>
