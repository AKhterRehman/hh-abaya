<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }} | H&H Abaya</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-border { border: 1px solid #ddd !important; }
        }
    </style>
</head>
<body class="bg-stone-100 font-sans text-stone-900 min-h-screen p-4 sm:p-8">

    <div class="max-w-3xl mx-auto">
        
        <!-- Print Trigger Bar -->
        <div class="no-print mb-4 flex items-center justify-between">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs text-stone-600 hover:underline">
                &larr; Back to Order
            </a>
            <button onclick="window.print()" class="px-5 py-2 bg-[#231F20] text-white text-xs font-bold uppercase rounded-lg shadow hover:bg-stone-800">
                Print Packing Slip / Invoice
            </button>
        </div>

        <!-- Invoice Paper -->
        <div class="bg-white p-8 sm:p-12 rounded-2xl shadow-xl print:shadow-none border border-stone-200 space-y-8">
            
            <!-- Header -->
            <div class="flex items-start justify-between border-b-2 border-stone-800 pb-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-16 h-16 rounded-full object-cover">
                    <div>
                        <h1 class="font-serif text-2xl font-bold tracking-wider text-[#231F20]">H&H ABAYA</h1>
                        <span class="text-[10px] uppercase tracking-[0.25em] text-stone-500 font-bold block">COLLECTION</span>
                        <p class="text-[11px] text-stone-500 mt-1">{{ $storeDetails['address'] }}</p>
                        <p class="text-[11px] text-stone-500">Phone: {{ $storeDetails['phone'] }} | {{ $storeDetails['email'] }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-xs uppercase font-bold text-stone-400 tracking-widest block">Official Packing Slip</span>
                    <h2 class="font-mono text-xl font-bold text-stone-900 mt-1">{{ $order->order_number }}</h2>
                    <span class="text-xs text-stone-500 block">Date: {{ $order->created_at->format('d M Y') }}</span>
                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-stone-100 border border-stone-300 mt-1 inline-block">
                        {{ $order->payment_method_label }}
                    </span>
                </div>
            </div>

            <!-- Ship To Box -->
            <div class="grid grid-cols-2 gap-6 text-xs">
                <div>
                    <span class="text-[10px] font-bold uppercase text-stone-400 block mb-1">Delivered To:</span>
                    <strong class="text-sm font-bold text-stone-900 block">{{ $order->customer_name }}</strong>
                    <p class="text-stone-600">{{ $order->shipping_address }}</p>
                    <p class="text-stone-600">{{ $order->city }}, {{ $order->province }}</p>
                    <p class="text-stone-600 font-mono mt-1 font-bold">Contact: {{ $order->customer_phone }}</p>
                </div>

                <div class="text-right">
                    <span class="text-[10px] font-bold uppercase text-stone-400 block mb-1">Logistics Information:</span>
                    <p class="text-stone-800">Courier: <strong>{{ $order->courier_name ?? 'Standard Dispatch' }}</strong></p>
                    @if($order->tracking_number)
                        <p class="text-stone-800 font-mono">Tracking #: <strong>{{ $order->tracking_number }}</strong></p>
                    @endif
                    <p class="text-stone-800 mt-2">Payment Status: <strong class="uppercase">{{ $order->payment_status }}</strong></p>
                    @if($order->payment_method === 'cod')
                        <p class="text-sm font-bold text-emerald-800 mt-1">Cash to Collect: PKR {{ number_format($order->total) }}</p>
                    @endif
                </div>
            </div>

            @if($order->order_notes)
                <div class="p-3 bg-stone-50 rounded-lg text-xs text-stone-700 border border-stone-200">
                    <strong>Tailoring / Delivery Notes:</strong> {{ $order->order_notes }}
                </div>
            @endif

            <!-- Items Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border border-stone-200">
                    <thead class="bg-stone-100 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2.5 px-3">Item Description</th>
                            <th class="py-2.5 px-3">Size</th>
                            <th class="py-2.5 px-3">Length</th>
                            <th class="py-2.5 px-3">Color</th>
                            <th class="py-2.5 px-3 text-center">Qty</th>
                            <th class="py-2.5 px-3 text-right">Unit Price</th>
                            <th class="py-2.5 px-3 text-right">Line Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-2.5 px-3 font-semibold text-stone-900">{{ $item->product_name }}</td>
                                <td class="py-2.5 px-3">{{ $item->size }}</td>
                                <td class="py-2.5 px-3 font-bold text-stone-800">{{ $item->length }}</td>
                                <td class="py-2.5 px-3">{{ $item->color }}</td>
                                <td class="py-2.5 px-3 text-center font-bold">{{ $item->quantity }}</td>
                                <td class="py-2.5 px-3 text-right">PKR {{ number_format($item->price) }}</td>
                                <td class="py-2.5 px-3 text-right font-bold">PKR {{ number_format($item->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="flex justify-end text-xs">
                <div class="w-64 space-y-1.5">
                    <div class="flex justify-between text-stone-600">
                        <span>Subtotal:</span>
                        <span>PKR {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-stone-600">
                        <span>Delivery Fee:</span>
                        <span>{{ $order->shipping_fee == 0 ? 'FREE' : 'PKR ' . number_format($order->shipping_fee) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-emerald-700 font-semibold">
                            <span>Discount:</span>
                            <span>-PKR {{ number_format($order->discount) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm font-bold text-stone-900 pt-2 border-t border-stone-800">
                        <span>Total Payable:</span>
                        <span>PKR {{ number_format($order->total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div class="border-t border-stone-200 pt-6 text-center text-[10px] text-stone-400 space-y-1">
                <p>Thank you for choosing H&H Abaya Collection. We cherish your trust in our craftsmanship.</p>
                <p>For exchanges within 7 days, please contact our WhatsApp concierge with this slip.</p>
            </div>

        </div>

    </div>

</body>
</html>
