@extends('layouts.admin')

@section('title', 'Store Settings & Client Inbox')
@section('header_title', 'Store Configuration & Messages')

@section('content')

<div class="space-y-10" x-data="{ activeTab: 'settings' }">
    
    <!-- Tab Switcher -->
    <div class="flex items-center space-x-3 border-b border-stone-200 pb-4 text-xs font-bold uppercase tracking-wider">
        <button type="button" 
                @click="activeTab = 'settings'" 
                class="px-4 py-2 rounded-xl transition"
                :class="activeTab === 'settings' ? 'bg-[#231F20] text-white shadow' : 'bg-white text-stone-600 hover:text-stone-900 border border-stone-200'">
            <i class="fa-solid fa-sliders mr-1.5"></i> Store Configuration
        </button>
        <button type="button" 
                @click="activeTab = 'messages'" 
                class="px-4 py-2 rounded-xl transition relative"
                :class="activeTab === 'messages' ? 'bg-[#231F20] text-white shadow' : 'bg-white text-stone-600 hover:text-stone-900 border border-stone-200'">
            <i class="fa-solid fa-envelope mr-1.5"></i> Client Messages Inbox ({{ $messages->total() }})
        </button>
    </div>

    <!-- 1. Store Settings Tab -->
    <div x-show="activeTab === 'settings'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- General Branding -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100 flex items-center gap-2">
                        <i class="fa-solid fa-store text-[#C5A059]"></i>
                        <span>Brand & Contact Information</span>
                    </h3>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Store Name</label>
                        <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'H&H Abaya Collection' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Store Tagline</label>
                        <input type="text" name="store_tagline" value="{{ $settings['store_tagline'] ?? 'Modern Modesty, Timeless Grace' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">WhatsApp Concierge Number (Include 92 country code)</label>
                        <input type="text" name="store_whatsapp" value="{{ $settings['store_whatsapp'] ?? '923001234567' }}" placeholder="923001234567" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-mono">
                        <span class="text-[10px] text-stone-400">Used for direct 1-click customer chat and order confirmation links</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Support Phone</label>
                            <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '+92 300 1234567' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Support Email</label>
                            <input type="email" name="store_email" value="{{ $settings['store_email'] ?? 'info@hhabaya.com' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Studio / Store Address</label>
                        <input type="text" name="store_address" value="{{ $settings['store_address'] ?? 'DHA Phase 5, Karachi, Pakistan' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>
                </div>

                <!-- Shipping & Announcement -->
                <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                    <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100 flex items-center gap-2">
                        <i class="fa-solid fa-truck text-[#C5A059]"></i>
                        <span>Shipping & Ticker Bar</span>
                    </h3>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Free Shipping Threshold (PKR)</label>
                            <input type="number" name="free_shipping_min" value="{{ $settings['free_shipping_min'] ?? 5000 }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-bold text-emerald-700">
                            <span class="text-[10px] text-stone-400">Orders above this enjoy free shipping</span>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-stone-700 block mb-1">Standard Delivery Fee (PKR)</label>
                            <input type="number" name="standard_shipping_fee" value="{{ $settings['standard_shipping_fee'] ?? 250 }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Announcement Bar Marquee Text</label>
                        <textarea name="announcement_text" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">{{ $settings['announcement_text'] ?? '' }}</textarea>
                    </div>

                    <div class="pt-2 border-t border-stone-100 space-y-3">
                        <h4 class="font-serif text-xs font-bold uppercase tracking-wider text-stone-800">Bank Wire Transfer Account</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-semibold text-stone-600 block mb-1">Bank Name</label>
                                <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? 'Meezan Bank Ltd' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 text-xs">
                            </div>
                            <div>
                                <label class="text-[10px] font-semibold text-stone-600 block mb-1">Account Title</label>
                                <input type="text" name="bank_account_title" value="{{ $settings['bank_account_title'] ?? 'H&H Abaya Collection' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 text-xs">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-[10px] font-semibold text-stone-600 block mb-1">Account Number</label>
                                <input type="text" name="bank_account_number" value="{{ $settings['bank_account_number'] ?? '0101-0103456789' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 text-xs font-mono">
                            </div>
                            <div>
                                <label class="text-[10px] font-semibold text-stone-600 block mb-1">IBAN</label>
                                <input type="text" name="bank_iban" value="{{ $settings['bank_iban'] ?? 'PK64MEZN0001010103456789' }}" class="w-full px-2.5 py-1.5 rounded-lg border border-stone-300 text-xs font-mono">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Brand Story & Socials -->
            <div class="bg-white p-6 rounded-2xl border border-stone-200 shadow-sm space-y-4">
                <h3 class="font-serif text-base font-bold text-stone-900 pb-2 border-b border-stone-100">
                    Brand Philosophy & Social Links
                </h3>

                <div>
                    <label class="text-xs font-semibold text-stone-700 block mb-1">About Us Story Bio</label>
                    <textarea name="about_story" rows="4" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs leading-relaxed">{{ $settings['about_story'] ?? '' }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Instagram Profile URL</label>
                        <input type="text" name="instagram_url" value="{{ $settings['instagram_url'] ?? 'https://instagram.com' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-stone-700 block mb-1">Facebook Page URL</label>
                        <input type="text" name="facebook_url" value="{{ $settings['facebook_url'] ?? 'https://facebook.com' }}" class="w-full px-3.5 py-2 rounded-xl border border-stone-300 text-xs">
                    </div>
                </div>
            </div>

            <button type="submit" class="px-8 py-3.5 bg-[#C5A059] hover:bg-[#A9833D] text-white text-xs font-bold uppercase tracking-widest rounded-xl transition shadow-xl">
                Save Store Settings
            </button>
        </form>
    </div>

    <!-- 2. Client Messages Inbox Tab -->
    <div x-show="activeTab === 'messages'" class="space-y-4" x-cloak>
        <div class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-stone-100 flex items-center justify-between">
                <div>
                    <h3 class="font-serif text-base font-bold text-stone-900">Inbound Customer Messages</h3>
                    <p class="text-xs text-stone-500">Submitted via the storefront contact form</p>
                </div>
                <span class="text-xs text-stone-500">{{ $messages->total() }} Total</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#FAF7F2] text-stone-700 font-bold border-b border-stone-200 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="py-3 px-4">From</th>
                            <th class="py-3 px-4">Subject</th>
                            <th class="py-3 px-4">Message</th>
                            <th class="py-3 px-4">Received</th>
                            <th class="py-3 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @forelse($messages as $msg)
                            <tr class="hover:bg-stone-50 transition {{ !$msg->is_read ? 'bg-amber-50/20 font-semibold' : '' }}">
                                <td class="py-3 px-4">
                                    <span class="font-bold text-stone-900 block">{{ $msg->name }}</span>
                                    <span class="text-[10px] text-stone-500 block">{{ $msg->email }}</span>
                                    @if($msg->phone)
                                        <span class="text-[10px] text-stone-400 font-mono block">{{ $msg->phone }}</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-stone-800 font-semibold max-w-xs truncate">
                                    {{ $msg->subject ?? 'General Inquiry' }}
                                </td>

                                <td class="py-3 px-4 text-stone-600 max-w-md">
                                    <p class="line-clamp-2 leading-relaxed">{{ $msg->message }}</p>
                                </td>

                                <td class="py-3 px-4 text-stone-400 whitespace-nowrap">
                                    {{ $msg->created_at->format('M d, Y h:i A') }}
                                </td>

                                <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                    @if(!$msg->is_read)
                                        <form action="{{ route('admin.messages.read', $msg->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 bg-stone-100 hover:bg-emerald-100 hover:text-emerald-800 rounded-lg text-[10px] font-bold uppercase transition" title="Mark Read">
                                                Mark Read
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1 text-stone-400 hover:text-rose-600 transition" title="Delete">
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-stone-400">Your message inbox is clear.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-stone-200">
                {{ $messages->links() }}
            </div>
        </div>
    </div>

</div>

@endsection
