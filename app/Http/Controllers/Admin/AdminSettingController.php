<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.settings.index', compact('settings', 'messages'));
    }

    public function update(Request $request)
    {
        $keys = [
            'store_name',
            'store_tagline',
            'store_email',
            'store_phone',
            'store_whatsapp',
            'store_address',
            'free_shipping_min',
            'standard_shipping_fee',
            'announcement_text',
            'bank_name',
            'bank_account_title',
            'bank_account_number',
            'bank_iban',
            'instagram_url',
            'facebook_url',
            'about_story',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Store settings updated successfully!');
    }

    public function markMessageRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }

    public function deleteMessage(ContactMessage $message)
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}
