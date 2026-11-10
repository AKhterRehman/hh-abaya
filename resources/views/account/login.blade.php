@extends('layouts.app')

@section('title', 'Sign In | H&H Abaya Collection')

@section('content')

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-[#E8DDD7] p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya" class="w-16 h-16 rounded-full mx-auto ring-2 ring-[#C5A059]/40">
            <h1 class="font-serif text-2xl font-bold text-stone-900">Welcome Back</h1>
            <p class="text-xs text-stone-500">Sign in to track orders & manage your saved items</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Email Address</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       placeholder="yourname@example.com" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-xs font-semibold text-stone-700">Password</label>
                </div>
                <input type="password" 
                       name="password" 
                       required 
                       placeholder="••••••••" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-stone-600">
                    <input type="checkbox" name="remember" class="rounded text-[#8C6D68] focus:ring-[#8C6D68]">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow">
                Sign In
            </button>
        </form>

        <div class="text-center text-xs text-stone-500 space-y-2 pt-2 border-t border-stone-100">
            <p>
                Don't have an account yet? 
                <a href="{{ route('register') }}" class="font-bold text-[#8C6D68] hover:underline">Create Account</a>
            </p>
            <p class="text-[11px] text-stone-400">
                Staff member? <a href="{{ route('admin.login') }}" class="underline hover:text-stone-700">Access Admin Portal</a>
            </p>
        </div>

    </div>
</div>

@endsection
