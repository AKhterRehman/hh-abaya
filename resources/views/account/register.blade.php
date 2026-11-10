@extends('layouts.app')

@section('title', 'Create Account | H&H Abaya Collection')

@section('content')

<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-[#E8DDD7] p-8 shadow-xl space-y-6">
        
        <div class="text-center space-y-2">
            <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya" class="w-16 h-16 rounded-full mx-auto ring-2 ring-[#C5A059]/40">
            <h1 class="font-serif text-2xl font-bold text-stone-900">Create an Account</h1>
            <p class="text-xs text-stone-500">Join H&H Abaya for faster checkout & exclusive member previews</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Full Name</label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="Ayesha Khan" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Email Address</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       placeholder="ayesha@example.com" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Phone / WhatsApp (Optional)</label>
                <input type="text" 
                       name="phone" 
                       value="{{ old('phone') }}" 
                       placeholder="0300 1234567" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Password</label>
                <input type="password" 
                       name="password" 
                       required 
                       placeholder="Minimum 6 characters" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <div>
                <label class="text-xs font-semibold text-stone-700 block mb-1">Confirm Password</label>
                <input type="password" 
                       name="password_confirmation" 
                       required 
                       placeholder="Re-enter password" 
                       class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow">
                Create My Account
            </button>
        </form>

        <div class="text-center text-xs text-stone-500 pt-2 border-t border-stone-100">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-[#8C6D68] hover:underline">Sign In</a>
        </div>

    </div>
</div>

@endsection
