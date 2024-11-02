<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
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
            ->with('orderDetails')
            ->get()
            ->sum(function ($order) {
                return $order->orderDetails->sum(function ($detail) {
                    return $detail->price * $detail->quantity;
                });
            });

        $totalOrders = Order::where('status', 'completed')->count();
        $totalOrders1 = Order::count();
        $totalUsers = User::count();
        $totalPendingOrders = Order::where('status', 'pending')->count();
        $totalCompletedOrders = Order::where('status', 'completed')->count();
        $daxacnhan = Order::where('status', 'confirmed')->count();
        $danggiao = Order::where('status', 'shipping')->count();
        $giaohuy = Order::where('status', 'cancelled')->count();
        $giaothatbai = Order::where('status', 'failed')->count();
        $giaothanhcong = Order::where('status', 'delivering')->count();

        // Lấy top 5 sản phẩm có doanh thu cao nhất
        $topRevenueProducts = Product::with('orderDetails')
            ->get()
            ->map(function ($product) {
                $revenue = $product->orderDetails->sum(function ($detail) {
                    return $detail->price * $detail->quantity;
                });
                return (object)[
                    'product' => $product,
                    'revenue' => $revenue,
                ];
            })
            ->sortByDesc('revenue')
            ->take(5)
            ->values();

        // Lấy top 5 sản phẩm bán chạy nhất
        $topProducts = Product::join('order_details', 'products.id', '=', 'order_details.order_id')
            ->select(
                'products.name',
                DB::raw('SUM(order_details.quantity) as sold_quantity'),
                DB::raw('SUM(order_details.price * order_details.quantity) as revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('sold_quantity')
            ->take(5)
            ->get();

        // Lấy top 5 sản phẩm lợi nhuận cao nhất
        $topProfitProducts = Product::select(
            'products.id',
            'products.name',
            'products.sku',
            DB::raw('SUM(order_details.price * order_details.quantity) as profit')
        )
            ->join('order_details', 'products.id', '=', 'order_details.order_id')
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->orderByDesc('profit')
            ->take(5)
            ->get();

        // Trả tất cả dữ liệu về View trong một lần
        return view('Admin.pages.dashboard', compact(
            'totalOrders',
            'totalOrders1',
            'totalUsers',
            'totalPendingOrders',
            'totalCompletedOrders',
            'daxacnhan',
            'danggiao',
            'giaothanhcong',
            'giaothatbai',
            'giaohuy',
            'totalRevenueThisMonth',
            'topRevenueProducts',
            'topProducts',
            'topProfitProducts'
        ));
    }
}
