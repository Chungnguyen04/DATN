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
        // Đếm số lượng đơn hàng theo trạng thái
        $statuses = ['pending', 'confirmed', 'shipping', 'delivering', 'failed', 'cancelled', 'completed'];
        $data = [];

        foreach ($statuses as $status) {
            $data["order_{$status}"] = Order::where('status', $status)->count();
        }

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

        return view('Admin.pages.dashboard', compact('data', 'totalOrders', 'totalRevenueThisMonth'));
    }
}
