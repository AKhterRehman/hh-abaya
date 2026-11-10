@extends('layouts.app')

@section('title', 'Our Heritage & Philosophy | H&H Abaya Collection')

@section('content')

<div class="bg-[#231F20] text-white py-16 border-b border-[#C5A059]/40 text-center space-y-3">
    <span class="text-xs uppercase tracking-[0.3em] text-[#C5A059] font-bold">The H&H Story</span>
    <h1 class="font-serif text-3xl sm:text-5xl font-bold">Modern Modesty, Timeless Grace</h1>
    <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light">
        Where reverent design meets the finest imported Saudi Nidha & Korean Georgette.
    </p>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
    
    <!-- Intro & Logo -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl border-4 border-white ring-2 ring-[#C5A059]/40">
            <img src="{{ asset('images/logo.jpg') }}" alt="H&H Abaya" class="w-full h-full object-cover">
        </div>

        <div class="space-y-4">
            <span class="text-xs uppercase tracking-[0.25em] text-[#8C6D68] font-bold">Crafted With Intention</span>
            <h2 class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 leading-snug">
                Redefining Contemporary Islamic Fashion
            </h2>
            <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                {{ \App\Models\Setting::get('about_story') }}
            </p>
            <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                Founded in Karachi, Pakistan, our flagship atelier was built on one clear conviction: that women should never have to compromise between full religious modesty and exquisite sartorial elegance.
            </p>
        </div>
    </div>

    <!-- Pillars / Values -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
        <div class="p-8 rounded-2xl bg-white border border-[#E8DDD7] space-y-3 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl mx-auto ring-1 ring-[#C5A059]/40">
                <i class="fa-solid fa-gem"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-stone-900">Imported Saudi Nidha</h3>
            <p class="text-xs text-stone-500 leading-relaxed">
                We source our fabrics directly from Dubai and Medina. Opaque, breathable, non-static, and colorfast wash after wash.
            </p>
        </div>

        <div class="p-8 rounded-2xl bg-white border border-[#E8DDD7] space-y-3 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl mx-auto ring-1 ring-[#C5A059]/40">
                <i class="fa-solid fa-scissors"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-stone-900">Artisan Master Tailoring</h3>
            <p class="text-xs text-stone-500 leading-relaxed">
                Every single seam, cuff scallop, and embroidery motif is hand-inspected by senior craftswomen before dispatch.
            </p>
        </div>

        <div class="p-8 rounded-2xl bg-white border border-[#E8DDD7] space-y-3 shadow-sm">
            <div class="w-12 h-12 rounded-xl bg-[#FAF7F2] text-[#8C6D68] flex items-center justify-center text-xl mx-auto ring-1 ring-[#C5A059]/40">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <h3 class="font-serif text-base font-bold text-stone-900">Inclusive Sizing</h3>
            <p class="text-xs text-stone-500 leading-relaxed">
                From petite 50" to statuesque 60" lengths and maternity nursing zipper options, our modest designs fit every stage of life.
            </p>
        </div>
    </div>

    <!-- Atelier Visit Banner -->
    <div class="p-8 rounded-3xl bg-[#231F20] text-white flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2">
            <h3 class="font-serif text-xl font-bold">Visit Our Design Studio in Karachi</h3>
            <p class="text-xs text-stone-300">Experience the touch and drape of our fabrics in person at DHA Phase 5.</p>
        </div>
        <a href="{{ route('pages.contact') }}" class="px-7 py-3 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
            Book an Appointment
        </a>
    </div>

</div>

@endsection
