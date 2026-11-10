<!-- Quick View Modal -->
<div x-show="quickViewModalOpen" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-cloak>
    
    <!-- Backdrop -->
    <div x-show="quickViewModalOpen" 
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/70 backdrop-blur-sm" 
         @click="quickViewModalOpen = false"></div>

    <div class="min-h-screen px-4 text-center flex items-center justify-center p-4">
        <div x-show="quickViewModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="inline-block w-full max-w-3xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border border-[#E8DDD7] relative z-10"
             @keydown.escape.window="quickViewModalOpen = false">
            
            <!-- Close Button -->
            <button type="button" 
                    @click="quickViewModalOpen = false" 
                    class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2">
                
                <!-- Product Image Gallery -->
                <div class="bg-[#FAF7F2] p-6 flex flex-col justify-between">
                    <div class="aspect-[3/4] w-full rounded-xl overflow-hidden shadow-inner border border-stone-200 relative bg-white">
                        <img :src="quickViewProduct.gallery_images && quickViewProduct.gallery_images.length > quickViewImageIndex ? quickViewProduct.gallery_images[quickViewImageIndex] : quickViewProduct.primary_image" 
                             :alt="quickViewProduct.name" 
                             class="w-full h-full object-cover">
                        <template x-if="quickViewProduct.has_discount">
                            <span class="absolute top-3 left-3 px-2.5 py-1 bg-[#8C6D68] text-white text-[10px] font-bold uppercase tracking-wider rounded-md shadow">
                                -<span x-text="quickViewProduct.discount_percent"></span>% OFF
                            </span>
                        </template>
                    </div>

                    <!-- Thumbnails -->
                    <template x-if="quickViewProduct.gallery_images && quickViewProduct.gallery_images.length > 1">
                        <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                            <template x-for="(thumb, idx) in quickViewProduct.gallery_images" :key="idx">
                                <button type="button" 
                                        @click="quickViewImageIndex = idx" 
                                        class="w-14 h-16 rounded-md overflow-hidden border-2 transition flex-shrink-0"
                                        :class="quickViewImageIndex === idx ? 'border-[#C5A059]' : 'border-stone-200 opacity-60 hover:opacity-100'">
                                    <img :src="thumb" class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Product Information & Options -->
                <div class="p-6 md:p-8 flex flex-col justify-between space-y-4">
                    <div>
                        <!-- Category & Rating -->
                        <div class="flex items-center justify-between text-xs text-stone-500 mb-1">
                            <span class="uppercase tracking-widest font-semibold text-[#8C6D68]" x-text="quickViewProduct.category_name"></span>
                            <div class="flex items-center text-amber-500 text-xs">
                                <i class="fa-solid fa-star"></i>
                                <span class="ml-1 font-semibold text-stone-700" x-text="quickViewProduct.rating"></span>
                                <span class="text-stone-400 ml-1">(<span x-text="quickViewProduct.reviews_count"></span>)</span>
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="font-serif text-xl font-bold text-stone-900 leading-snug" x-text="quickViewProduct.name"></h3>

                        <!-- Pricing -->
                        <div class="mt-2 flex items-baseline gap-3">
                            <span class="text-xl font-bold text-[#8C6D68]" 
                                  x-text="'PKR ' + (quickViewProduct.sale_price || quickViewProduct.regular_price)"></span>
                            <template x-if="quickViewProduct.has_discount">
                                <span class="text-sm text-stone-400 line-through" 
                                      x-text="'PKR ' + quickViewProduct.regular_price"></span>
                            </template>
                        </div>

                        <!-- Fabric note -->
                        <template x-if="quickViewProduct.fabric">
                            <div class="mt-2 text-xs text-stone-600 flex items-center gap-1.5 bg-[#FAF7F2] px-2.5 py-1.5 rounded-md border border-[#E8DDD7]">
                                <i class="fa-solid fa-feather text-[#C5A059]"></i>
                                <span>Fabric: <strong class="text-stone-800" x-text="quickViewProduct.fabric"></strong></span>
                            </div>
                        </template>

                        <!-- Description excerpt -->
                        <p class="text-xs text-stone-500 mt-3 line-clamp-3 leading-relaxed" x-text="quickViewProduct.short_description"></p>

                        <!-- Size Selector -->
                        <template x-if="quickViewProduct.sizes && quickViewProduct.sizes.length > 0">
                            <div class="mt-4">
                                <div class="flex justify-between items-center text-xs mb-1.5">
                                    <span class="font-semibold text-stone-800">Select Standard Size:</span>
                                    <button type="button" @click="sizeGuideModalOpen = true" class="text-[#8C6D68] underline text-[11px] hover:text-[#C5A059]">
                                        <i class="fa-solid fa-ruler-combined mr-1"></i> Size Guide
                                    </button>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="sz in quickViewProduct.sizes" :key="sz">
                                        <button type="button" 
                                                @click="quickViewSize = sz" 
                                                class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition"
                                                :class="quickViewSize === sz ? 'bg-[#231F20] text-white border-[#231F20]' : 'border-stone-300 text-stone-700 hover:border-stone-400'"
                                                x-text="sz">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Length Selector (Crucial for Abayas!) -->
                        <template x-if="quickViewProduct.lengths && quickViewProduct.lengths.length > 0">
                            <div class="mt-3">
                                <div class="text-xs font-semibold text-stone-800 mb-1.5">
                                    Select Abaya Length (Inches):
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="len in quickViewProduct.lengths" :key="len">
                                        <button type="button" 
                                                @click="quickViewLength = len" 
                                                class="px-3 py-1 text-xs font-semibold rounded-lg border transition"
                                                :class="quickViewLength === len ? 'bg-[#8C6D68] text-white border-[#8C6D68]' : 'border-stone-300 text-stone-700 hover:border-stone-400'"
                                                x-text="len">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Color Selector -->
                        <template x-if="quickViewProduct.colors && quickViewProduct.colors.length > 0">
                            <div class="mt-3">
                                <div class="text-xs font-semibold text-stone-800 mb-1.5">
                                    Color: <span class="font-normal text-stone-600" x-text="quickViewColor"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <template x-for="col in quickViewProduct.colors" :key="col.name">
                                        <button type="button" 
                                                @click="quickViewColor = col.name" 
                                                class="w-7 h-7 rounded-full border-2 transition p-0.5 flex items-center justify-center"
                                                :class="quickViewColor === col.name ? 'border-[#C5A059] ring-2 ring-[#C5A059]/30' : 'border-transparent hover:border-stone-400'"
                                                :title="col.name">
                                            <span class="w-full h-full rounded-full border border-stone-200" :style="`background-color: ${col.code}`"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <!-- Quantity Selector -->
                        <div class="mt-4 flex items-center gap-3">
                            <span class="text-xs font-semibold text-stone-800">Quantity:</span>
                            <div class="flex items-center border border-stone-300 rounded-lg overflow-hidden bg-white">
                                <button type="button" 
                                        @click="if (quickViewQuantity > 1) quickViewQuantity--" 
                                        class="px-3 py-1 text-stone-600 hover:bg-stone-100 text-xs">
                                    <i class="fa-solid fa-minus text-[10px]"></i>
                                </button>
                                <span class="px-4 text-xs font-bold text-stone-800" x-text="quickViewQuantity"></span>
                                <button type="button" 
                                        @click="quickViewQuantity++" 
                                        class="px-3 py-1 text-stone-600 hover:bg-stone-100 text-xs">
                                    <i class="fa-solid fa-plus text-[10px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-stone-100 space-y-2">
                        <button type="button" 
                                @click="addToCartAjax(quickViewProduct.id, quickViewSize, quickViewLength, quickViewColor, quickViewQuantity); quickViewModalOpen = false;"
                                class="w-full py-3.5 bg-[#231F20] hover:bg-[#8C6D68] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <span>Add to Shopping Bag</span>
                        </button>
                        <a :href="quickViewProduct.url" 
                           class="w-full py-2 text-center text-xs text-[#8C6D68] hover:text-[#C5A059] font-medium block">
                            View Full Product Specifications & Customer Reviews &rarr;
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
