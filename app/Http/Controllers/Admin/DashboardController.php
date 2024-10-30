<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Variant;

class DashboardController extends Controller
{
    public function index()
    {
        

        // Tổng doanh thu của tháng hiện tại
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $totalRevenueThisMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->with('orderDetails') // Load mối quan hệ orderDetails
            ->get()
            ->sum(function($order) {
                return $order->orderDetails->sum(function($detail) {
                    return $detail->price * $detail->quantity;
                });
            });

        $totalOrders = Order::where('status', 'completed')->count();

        return view('Admin.pages.dashboard', compact( 'totalOrders', 'totalRevenueThisMonth'));
    }
}
