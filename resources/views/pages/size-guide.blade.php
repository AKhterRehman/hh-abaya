@extends('layouts.app')

@section('title', 'Abaya Size & Length Guide | H&H Abaya Collection')

@section('content')

<div class="bg-[#231F20] text-white py-12 border-b border-[#C5A059]/40 text-center space-y-2">
    <span class="text-xs uppercase tracking-[0.3em] text-[#C5A059] font-bold">Fit Concierge</span>
    <h1 class="font-serif text-3xl sm:text-4xl font-bold">Abaya Sizing & Length Guide</h1>
    <p class="text-xs sm:text-sm text-stone-300 max-w-lg mx-auto font-light">
        Ensure your modest silhouette falls at the perfect ankle level with our precision measurement guide.
    </p>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12"
     x-data="{
         customerHeight: '5_4',
         lengthsMap: {
             '4_11': '50\" (127 cm)',
             '5_0': '50\" (127 cm)',
             '5_1': '52\" (132 cm)',
             '5_2': '52\" (132 cm)',
             '5_3': '54\" (137 cm) - Standard',
             '5_4': '54\" (137 cm) - Standard',
             '5_5': '56\" (142 cm)',
             '5_6': '56\" (142 cm)',
             '5_7': '58\" (147 cm)',
             '5_8': '58\" (147 cm)',
             '5_9': '60\" (152 cm)',
             '5_10': '60\" (152 cm)',
         }
     }">

    <!-- Interactive Length Calculator Tool -->
    <div class="p-8 rounded-3xl bg-gradient-to-br from-[#FAF7F2] to-white border-2 border-[#C5A059]/40 shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <span class="inline-block px-3 py-1 rounded-full bg-[#8C6D68] text-white text-[10px] font-bold uppercase tracking-widest">
                Interactive Tool
            </span>
            <h2 class="font-serif text-2xl font-bold text-stone-900">Find Your Recommended Abaya Length</h2>
            <p class="text-xs text-stone-500">Select your height in feet and inches to instantly see your optimal abaya size.</p>
        </div>

        <div class="max-w-md mx-auto">
            <label class="text-xs font-bold text-stone-800 block mb-2 text-center">Your Height:</label>
            <select x-model="customerHeight" class="w-full px-4 py-3 bg-white rounded-xl border border-stone-300 text-sm font-semibold text-stone-800 focus:ring-2 focus:ring-[#C5A059] shadow-sm">
                <option value="4_11">4 Feet 11 Inches (150 cm)</option>
                <option value="5_0">5 Feet 0 Inches (152 cm)</option>
                <option value="5_1">5 Feet 1 Inch (155 cm)</option>
                <option value="5_2">5 Feet 2 Inches (157 cm)</option>
                <option value="5_3">5 Feet 3 Inches (160 cm)</option>
                <option value="5_4" selected>5 Feet 4 Inches (162 cm) - Standard</option>
                <option value="5_5">5 Feet 5 Inches (165 cm)</option>
                <option value="5_6">5 Feet 6 Inches (167 cm)</option>
                <option value="5_7">5 Feet 7 Inches (170 cm)</option>
                <option value="5_8">5 Feet 8 Inches (173 cm)</option>
                <option value="5_9">5 Feet 9 Inches (175 cm)</option>
                <option value="5_10">5 Feet 10 Inches or taller</option>
            </select>

            <div class="mt-6 p-5 rounded-2xl bg-[#231F20] text-white text-center shadow-lg border border-[#C5A059]/50">
                <span class="text-[11px] text-amber-200 uppercase tracking-widest font-semibold block">Your Ideal Length:</span>
                <span class="font-serif text-3xl font-bold text-[#C5A059] block my-1" x-text="lengthsMap[customerHeight]"></span>
                <p class="text-[11px] text-stone-300">
                    If wearing high heels (3"+), consider selecting one length longer for floor sweep.
                </p>
            </div>
        </div>
    </div>

    <!-- Length Mapping Table -->
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 shadow-sm space-y-4">
        <h3 class="font-serif text-xl font-bold text-stone-900 pb-2 border-b border-stone-200">
            Standard Height vs. Abaya Length Chart
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-900 font-bold border-b border-stone-200">
                    <tr>
                        <th class="py-3 px-4">Customer Height</th>
                        <th class="py-3 px-4">Abaya Length (Inches)</th>
                        <th class="py-3 px-4">Abaya Length (CM)</th>
                        <th class="py-3 px-4">Drape Fit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    <tr>
                        <td class="py-2.5 px-4 font-semibold">4'10" - 5'0"</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">50"</td>
                        <td class="py-2.5 px-4">127 cm</td>
                        <td class="py-2.5 px-4 text-stone-500">Falls right at ankle</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-semibold">5'1" - 5'2"</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">52"</td>
                        <td class="py-2.5 px-4">132 cm</td>
                        <td class="py-2.5 px-4 text-stone-500">Falls right at ankle</td>
                    </tr>
                    <tr class="bg-amber-50/30">
                        <td class="py-2.5 px-4 font-semibold text-[#8C6D68]">5'3" - 5'4" (Most Common)</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">54"</td>
                        <td class="py-2.5 px-4">137 cm</td>
                        <td class="py-2.5 px-4 text-stone-600 font-medium">Standard floor graze</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-semibold">5'5" - 5'6"</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">56"</td>
                        <td class="py-2.5 px-4">142 cm</td>
                        <td class="py-2.5 px-4 text-stone-500">Falls right at ankle</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-semibold">5'7" - 5'8"</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">58"</td>
                        <td class="py-2.5 px-4">147 cm</td>
                        <td class="py-2.5 px-4 text-stone-500">Falls right at ankle</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-semibold">5'9" - 5'11"+</td>
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">60"</td>
                        <td class="py-2.5 px-4">152 cm</td>
                        <td class="py-2.5 px-4 text-stone-500">Tall floor graze</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Body Measurements Chart -->
    <div class="bg-white rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 shadow-sm space-y-4">
        <h3 class="font-serif text-xl font-bold text-stone-900 pb-2 border-b border-stone-200">
            Standard Body Sizing (Bust & Sleeves)
        </h3>
        <p class="text-xs text-stone-500">
            Our abayas feature comfortable, relaxed fits intended to be modest without clinging. Measurements below represent the garment flat circumference.
        </p>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF7F2] text-stone-900 font-bold border-b border-stone-200">
                    <tr>
                        <th class="py-3 px-4">Size</th>
                        <th class="py-3 px-4">UK / PK Fit</th>
                        <th class="py-3 px-4">Garment Bust</th>
                        <th class="py-3 px-4">Garment Hips</th>
                        <th class="py-3 px-4">Sleeve Length</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    <tr>
                        <td class="py-2.5 px-4 font-bold">XS</td>
                        <td class="py-2.5 px-4 text-stone-500">UK 6 - 8</td>
                        <td class="py-2.5 px-4">38 inches</td>
                        <td class="py-2.5 px-4">42 inches</td>
                        <td class="py-2.5 px-4">26 inches</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-bold">S</td>
                        <td class="py-2.5 px-4 text-stone-500">UK 8 - 10</td>
                        <td class="py-2.5 px-4">40 inches</td>
                        <td class="py-2.5 px-4">44 inches</td>
                        <td class="py-2.5 px-4">27 inches</td>
                    </tr>
                    <tr class="bg-amber-50/20">
                        <td class="py-2.5 px-4 font-bold text-[#8C6D68]">M</td>
                        <td class="py-2.5 px-4 text-stone-600 font-semibold">UK 12 - 14</td>
                        <td class="py-2.5 px-4">42 inches</td>
                        <td class="py-2.5 px-4">46 inches</td>
                        <td class="py-2.5 px-4">27.5 inches</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-bold">L</td>
                        <td class="py-2.5 px-4 text-stone-500">UK 14 - 16</td>
                        <td class="py-2.5 px-4">45 inches</td>
                        <td class="py-2.5 px-4">49 inches</td>
                        <td class="py-2.5 px-4">28 inches</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 px-4 font-bold">XL</td>
                        <td class="py-2.5 px-4 text-stone-500">UK 18 - 20</td>
                        <td class="py-2.5 px-4">48 inches</td>
                        <td class="py-2.5 px-4">52 inches</td>
                        <td class="py-2.5 px-4">28.5 inches</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- How to Measure & Custom Requests -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 rounded-2xl bg-white border border-[#E8DDD7] space-y-3">
            <h4 class="font-serif text-base font-bold text-stone-900">How to Measure Your Abaya Length</h4>
            <ol class="list-decimal pl-4 space-y-1.5 text-xs text-stone-600 leading-relaxed">
                <li>Stand upright without shoes against a flat wall.</li>
                <li>Measure from the highest point of your shoulder down to the top of your foot or where you desire the hemline to fall.</li>
                <li>Ensure the measuring tape hangs straight down along your natural posture.</li>
            </ol>
        </div>

        <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-[#C5A059]/40 space-y-3">
            <h4 class="font-serif text-base font-bold text-stone-900">Need Custom Tailoring?</h4>
            <p class="text-xs text-stone-600 leading-relaxed">
                We accommodate maternity, nursing zipper requests, and in-between lengths (e.g. 51" or 55"). Leave a note in the checkout box or chat with our master tailors directly.
            </p>
            <a href="https://wa.me/{{ \App\Models\Setting::get('store_whatsapp', '923001234567') }}?text=Assalam%20o%20Alaikum!%20I%20need%20custom%20abaya%20measurements." 
               target="_blank" 
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow">
                <i class="fa-brands fa-whatsapp text-sm"></i>
                <span>Chat with Custom Sizing Team</span>
            </a>
        </div>
    </div>

</div>

@endsection
