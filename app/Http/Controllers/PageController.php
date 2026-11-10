<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function sizeGuide()
    {
        return view('pages.size-guide');
    }

    public function contact()
    {
        $settings = [
            'store_name' => Setting::get('store_name', 'H&H Abaya Collection'),
            'store_phone' => Setting::get('store_phone', '+92 300 1234567'),
            'store_whatsapp' => Setting::get('store_whatsapp', '923001234567'),
            'store_email' => Setting::get('store_email', 'info@hhabaya.com'),
            'store_address' => Setting::get('store_address', 'DHA Phase 5, Karachi, Pakistan'),
        ];
        return view('pages.contact', compact('settings'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($request->all());

        return back()->with('success', 'JazakAllah! Your message has been received. Our concierge team will reach out to you within 24 hours.');
    }

    public function shippingPolicy()
    {
        return view('pages.shipping');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }
}
