<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'paid')
            ->orWhere('order_status', 'delivered')
            ->sum('total');

        $totalOrders = Order::count();
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $processingOrders = Order::where('order_status', 'processing')->count();
        $shippedOrders = Order::where('order_status', 'shipped')->count();
        $deliveredOrders = Order::where('order_status', 'delivered')->count();

        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        $unreadMessagesCount = ContactMessage::where('is_read', false)->count();

        $recentOrders = Order::latest()->take(6)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->latest()->take(5)->get();
        $topProducts = Product::orderBy('reviews_count', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippedOrders',
            'deliveredOrders',
            'totalProducts',
            'totalCustomers',
            'lowStockCount',
            'unreadMessagesCount',
            'recentOrders',
            'lowStockProducts',
            'topProducts'
        ));
    }
}
