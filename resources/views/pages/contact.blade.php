@extends('layouts.app')

@section('title', 'Contact Concierge | H&H Abaya Collection')

@section('content')

<div class="bg-[#231F20] text-white py-12 border-b border-[#C5A059]/40 text-center space-y-2">
    <span class="text-xs uppercase tracking-[0.3em] text-[#C5A059] font-bold">Client Concierge</span>
    <h1 class="font-serif text-3xl sm:text-4xl font-bold">We Are Here For You</h1>
    <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light">
        Reach out for styling consultations, custom length adjustments, or order inquiries.
    </p>
</div>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Contact Details & Direct WhatsApp (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 space-y-6 shadow-sm">
                <h3 class="font-serif text-xl font-bold text-stone-900 pb-3 border-b border-stone-200">
                    Get In Touch
                </h3>

                <div class="space-y-4 text-xs text-stone-600">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#FAF7F2] text-[#C5A059] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <strong class="text-stone-900 block">Flagship Atelier:</strong>
                            <p class="text-stone-500">{{ $settings['store_address'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#FAF7F2] text-[#C5A059] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <strong class="text-stone-900 block">Phone Support:</strong>
                            <p class="text-stone-500">{{ $settings['store_phone'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#FAF7F2] text-[#C5A059] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <strong class="text-stone-900 block">Email Inquiries:</strong>
                            <p class="text-stone-500">{{ $settings['store_email'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#FAF7F2] text-[#C5A059] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <strong class="text-stone-900 block">Business Hours:</strong>
                            <p class="text-stone-500">Monday - Saturday: 10:00 AM - 9:00 PM (PST)</p>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-stone-100">
                    <a href="https://wa.me/{{ $settings['store_whatsapp'] }}?text=Assalam%20o%20Alaikum!%20I%20have%20an%20inquiry%20regarding%20an%20order." 
                       target="_blank" 
                       class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider flex items-center justify-center gap-2 shadow transition">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Instant WhatsApp Chat</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Contact Form (7 cols) -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="font-serif text-xl font-bold text-stone-900">Send an Inquiry</h3>
                    <p class="text-xs text-stone-500 mt-1">Our concierge team typically replies within 2 to 4 business hours.</p>
                </div>

                <form action="{{ route('pages.contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Your Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="name" required placeholder="Ayesha Khan" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Email Address <span class="text-rose-500">*</span></label>
                            <input type="email" name="email" required placeholder="ayesha@example.com" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Phone / WhatsApp Number</label>
                            <input type="text" name="phone" placeholder="0300 1234567" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Subject</label>
                            <input type="text" name="subject" placeholder="e.g. Custom length sizing inquiry" class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Message <span class="text-rose-500">*</span></label>
                        <textarea name="message" rows="5" required placeholder="Please provide any details, height measurements, or specific abaya style inquiries..." class="w-full px-3.5 py-2.5 rounded-xl border border-stone-300 text-xs focus:ring-2 focus:ring-[#C5A059] focus:outline-none"></textarea>
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-wider rounded-xl transition shadow">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
