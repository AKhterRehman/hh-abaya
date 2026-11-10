<!-- Abaya Sizing & Length Guide Modal -->
<div x-show="sizeGuideModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-cloak>
    
    <div x-show="sizeGuideModalOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 backdrop-blur-sm" 
         @click="sizeGuideModalOpen = false"></div>

    <div class="min-h-screen px-4 text-center flex items-center justify-center p-4">
        <div x-show="sizeGuideModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border border-[#E8DDD7] p-6 sm:p-8 relative z-10"
             @keydown.escape.window="sizeGuideModalOpen = false"
             x-data="{ unit: 'inches' }">
            
            <!-- Header -->
            <div class="flex items-center justify-between pb-4 border-b border-stone-200">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ruler-combined text-[#C5A059] text-xl"></i>
                    <div>
                        <h3 class="font-serif text-lg font-bold text-stone-900">Abaya Sizing & Length Guide</h3>
                        <p class="text-xs text-stone-500">Find your ideal modest drape and floor-length fit</p>
                    </div>
                </div>
                <button type="button" @click="sizeGuideModalOpen = false" class="text-stone-400 hover:text-stone-700 p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="mt-6 space-y-6 text-xs text-stone-700">
                
                <!-- 1. Height to Abaya Length Recommendation -->
                <div>
                    <h4 class="font-serif text-sm font-bold text-[#8C6D68] uppercase tracking-wider mb-2">
                        1. Recommended Abaya Length (Height-Based)
                    </h4>
                    <p class="text-[11px] text-stone-500 mb-3">
                        Abayas are designed to fall gracefully around ankle to top-of-shoe level. If you plan to wear high heels, choose one size longer.
                    </p>
                    <div class="overflow-x-auto border border-stone-200 rounded-xl">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-[#FAF7F2] text-stone-900 font-semibold border-b border-stone-200">
                                <tr>
                                    <th class="py-2.5 px-4">Your Height</th>
                                    <th class="py-2.5 px-4">Height (cm)</th>
                                    <th class="py-2.5 px-4 text-[#8C6D68]">Recommended Length</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                <tr class="hover:bg-amber-50/40">
                                    <td class="py-2 px-4 font-medium">4'10" - 5'0"</td>
                                    <td class="py-2 px-4 text-stone-500">147 - 152 cm</td>
                                    <td class="py-2 px-4 font-bold text-stone-900">50" (127 cm)</td>
                                </tr>
                                <tr class="hover:bg-amber-50/40">
                                    <td class="py-2 px-4 font-medium">5'1" - 5'2"</td>
                                    <td class="py-2 px-4 text-stone-500">153 - 157 cm</td>
                                    <td class="py-2 px-4 font-bold text-stone-900">52" (132 cm)</td>
                                </tr>
                                <tr class="hover:bg-amber-50/40 bg-amber-50/20">
                                    <td class="py-2 px-4 font-medium">5'3" - 5'4" (Standard)</td>
                                    <td class="py-2 px-4 text-stone-500">158 - 162 cm</td>
                                    <td class="py-2 px-4 font-bold text-[#8C6D68]">54" (137 cm) - Popular</td>
                                </tr>
                                <tr class="hover:bg-amber-50/40">
                                    <td class="py-2 px-4 font-medium">5'5" - 5'6"</td>
                                    <td class="py-2 px-4 text-stone-500">163 - 167 cm</td>
                                    <td class="py-2 px-4 font-bold text-stone-900">56" (142 cm)</td>
                                </tr>
                                <tr class="hover:bg-amber-50/40">
                                    <td class="py-2 px-4 font-medium">5'7" - 5'8"</td>
                                    <td class="py-2 px-4 text-stone-500">168 - 172 cm</td>
                                    <td class="py-2 px-4 font-bold text-stone-900">58" (147 cm)</td>
                                </tr>
                                <tr class="hover:bg-amber-50/40">
                                    <td class="py-2 px-4 font-medium">5'9" - 5'11"+</td>
                                    <td class="py-2 px-4 text-stone-500">173 - 180+ cm</td>
                                    <td class="py-2 px-4 font-bold text-stone-900">60" (152 cm)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Standard Body Sizing Chart -->
                <div>
                    <h4 class="font-serif text-sm font-bold text-[#8C6D68] uppercase tracking-wider mb-2">
                        2. Body Size Measurements (Inches)
                    </h4>
                    <div class="overflow-x-auto border border-stone-200 rounded-xl">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-[#FAF7F2] text-stone-900 font-semibold border-b border-stone-200">
                                <tr>
                                    <th class="py-2.5 px-4">Size</th>
                                    <th class="py-2.5 px-4">Bust</th>
                                    <th class="py-2.5 px-4">Waist</th>
                                    <th class="py-2.5 px-4">Hips</th>
                                    <th class="py-2.5 px-4">Sleeve</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-stone-100">
                                <tr>
                                    <td class="py-2 px-4 font-bold">XS (UK 6-8)</td>
                                    <td class="py-2 px-4">36" - 38"</td>
                                    <td class="py-2 px-4">32" - 34"</td>
                                    <td class="py-2 px-4">40" - 42"</td>
                                    <td class="py-2 px-4">26"</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 font-bold">S (UK 8-10)</td>
                                    <td class="py-2 px-4">38" - 40"</td>
                                    <td class="py-2 px-4">34" - 36"</td>
                                    <td class="py-2 px-4">42" - 44"</td>
                                    <td class="py-2 px-4">27"</td>
                                </tr>
                                <tr class="bg-amber-50/20">
                                    <td class="py-2 px-4 font-bold text-[#8C6D68]">M (UK 12-14)</td>
                                    <td class="py-2 px-4">40" - 42"</td>
                                    <td class="py-2 px-4">36" - 38"</td>
                                    <td class="py-2 px-4">44" - 46"</td>
                                    <td class="py-2 px-4">27.5"</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 font-bold">L (UK 14-16)</td>
                                    <td class="py-2 px-4">43" - 45"</td>
                                    <td class="py-2 px-4">39" - 41"</td>
                                    <td class="py-2 px-4">47" - 49"</td>
                                    <td class="py-2 px-4">28"</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 font-bold">XL (UK 18-20)</td>
                                    <td class="py-2 px-4">46" - 48"</td>
                                    <td class="py-2 px-4">42" - 44"</td>
                                    <td class="py-2 px-4">50" - 52"</td>
                                    <td class="py-2 px-4">28.5"</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Custom Sizing Note -->
                <div class="p-3.5 bg-[#FAF7F2] rounded-xl border border-[#E8DDD7] flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-[#C5A059] mt-0.5 text-sm"></i>
                    <div>
                        <strong class="text-stone-900 block mb-0.5">Custom Sizing & Lengths Available</strong>
                        <p class="text-[11px] text-stone-500">
                            Need a custom length (e.g. 53" or 57") or bust adjustment? Mention your specific height and requirements in the <em>Order Notes</em> during checkout or message our WhatsApp team!
                        </p>
                    </div>
                </div>

            </div>

            <div class="mt-6 text-right">
                <button type="button" 
                        @click="sizeGuideModalOpen = false" 
                        class="px-6 py-2 bg-[#231F20] text-white rounded-lg text-xs font-semibold uppercase tracking-wider hover:bg-[#8C6D68] transition">
                    Got it, Close
                </button>
            </div>

        </div>
    </div>
</div>
