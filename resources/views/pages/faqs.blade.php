@extends('layouts.app')

@section('title', 'Frequently Asked Questions | H&H Abaya Collection')

@section('content')

<div class="bg-[#231F20] text-white py-12 border-b border-[#C5A059]/40 text-center space-y-2">
    <span class="text-xs uppercase tracking-[0.3em] text-[#C5A059] font-bold">Help Center</span>
    <h1 class="font-serif text-3xl sm:text-4xl font-bold">Frequently Asked Questions</h1>
    <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light">
        Everything you need to know about our abaya fabrics, sizing, and ordering.
    </p>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-6" x-data="{ open: null }">
    
    @php
        $faqs = [
            [
                'q' => 'What is Dubai Nidha fabric and is it transparent?',
                'a' => 'Original Dubai Nidha is an ultra-premium, 100% polyester micro-weave fabric celebrated across the Gulf for its fluid drape, soft cool-touch feel, and supreme breathability. It is 100% non-transparent and opaque, allowing you to wear it comfortably with complete peace of mind.'
            ],
            [
                'q' => 'How do I choose the correct abaya length for my height?',
                'a' => 'Abaya length is measured from the shoulder to the bottom hem in inches. For example, if your height is 5\'3" - 5\'4", length 54" is the standard size that falls gracefully at the ankle. You can visit our interactive Size Guide page to select your height and see our recommended size.'
            ],
            [
                'q' => 'Can I request a custom length or maternity adjustments?',
                'a' => 'Yes! We happily cater to custom length requests (such as 51", 53", or 57") as well as hidden nursing zipper requests. Simply write your instructions in the "Order Notes" box during checkout or send us a message on WhatsApp.'
            ],
            [
                'q' => 'Do you offer Cash on Delivery across Pakistan?',
                'a' => 'Yes, Cash on Delivery (COD) is available for all cities and towns nationwide without extra COD fees.'
            ],
            [
                'q' => 'What is your delivery timeframe?',
                'a' => 'Orders are usually tailored and dispatched within 1 to 2 days, and delivered to your doorstep within 3 to 5 business days.'
            ],
            [
                'q' => 'What if the abaya size does not fit me comfortably?',
                'a' => 'We offer an easy 7-day exchange guarantee. Simply contact our concierge via WhatsApp with your order number and desired replacement size.'
            ]
        ];
    @endphp

    @foreach($faqs as $i => $faq)
        <div class="bg-white rounded-2xl border border-[#E8DDD7] overflow-hidden shadow-sm">
            <button type="button" 
                    @click="open = (open === {{ $i }} ? null : {{ $i }})" 
                    class="w-full p-5 text-left flex items-center justify-between text-xs sm:text-sm font-bold text-stone-900 hover:text-[#8C6D68] transition">
                <span>{{ $faq['q'] }}</span>
                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" 
                   :class="open === {{ $i }} ? 'rotate-180 text-[#8C6D68]' : 'text-stone-400'"></i>
            </button>
            <div x-show="open === {{ $i }}" x-collapse class="px-5 pb-5 text-xs text-stone-600 leading-relaxed border-t border-stone-100 pt-3" x-cloak>
                {{ $faq['a'] }}
            </div>
        </div>
    @endforeach

</div>

@endsection
