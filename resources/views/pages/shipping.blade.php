@extends('layouts.app')

@section('title', 'Shipping & Return Policy | H&H Abaya Collection')

@section('content')

<div class="bg-[#231F20] text-white py-12 border-b border-[#C5A059]/40 text-center space-y-2">
    <span class="text-xs uppercase tracking-[0.3em] text-[#C5A059] font-bold">Client Care</span>
    <h1 class="font-serif text-3xl sm:text-4xl font-bold">Shipping & Exchange Policy</h1>
    <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light">
        Transparent terms designed for a seamless, trustworthy shopping experience.
    </p>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-8 text-xs sm:text-sm text-stone-600 leading-relaxed">
    
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 space-y-4 shadow-sm">
        <h3 class="font-serif text-lg font-bold text-stone-900 flex items-center gap-2">
            <i class="fa-solid fa-truck text-[#C5A059]"></i>
            <span>Nationwide Delivery (Pakistan)</span>
        </h3>
        <p>
            We dispatch all orders via certified courier partners (TCS, Call Courier, Leopards). Once your order is tailored and packed, you will receive an SMS and email notification with your live tracking number.
        </p>
        <ul class="list-disc pl-5 space-y-1 text-xs">
            <li><strong>Delivery Timeline:</strong> Major cities (Karachi, Lahore, Islamabad, Rawalpindi) take 2 to 4 business days. Regional and remote destinations take 3 to 5 business days.</li>
            <li><strong>Free Delivery:</strong> Orders exceeding PKR 5,000 enjoy 100% complimentary shipping.</li>
            <li><strong>Standard Shipping Fee:</strong> PKR 250 for orders below PKR 5,000.</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 space-y-4 shadow-sm">
        <h3 class="font-serif text-lg font-bold text-stone-900 flex items-center gap-2">
            <i class="fa-solid fa-arrows-rotate text-[#C5A059]"></i>
            <span>7-Day Hassle-Free Exchange Policy</span>
        </h3>
        <p>
            Your satisfaction and confidence in your modest silhouette are paramount. If an abaya's length, sleeve fit, or size is not completely comfortable, you may exchange it within 7 days of receiving the package.
        </p>
        <ul class="list-disc pl-5 space-y-1 text-xs">
            <li>Item must be unworn, unwashed, and with all original tags and packaging intact.</li>
            <li>To initiate an exchange, message our WhatsApp concierge at <strong>{{ \App\Models\Setting::get('store_phone') }}</strong> with your Order Number and desired replacement length/size.</li>
            <li>Rider will deliver your exchange garment and collect the original piece at your doorstep.</li>
        </ul>
    </div>

    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 space-y-4 shadow-sm">
        <h3 class="font-serif text-lg font-bold text-stone-900 flex items-center gap-2">
            <i class="fa-solid fa-money-bill-wave text-[#C5A059]"></i>
            <span>Payment Methods</span>
        </h3>
        <p>
            We offer <strong>Cash on Delivery (COD)</strong> across Pakistan, as well as <strong>Direct Bank Wire Transfer (Meezan Bank)</strong> and major online debit/credit cards.
        </p>
    </div>

</div>

@endsection
