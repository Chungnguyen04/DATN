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
            ->with('orderDetails') // Load mối quan hệ orderDetails
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
        $topRevenueProducts = Product::with([
            'orderDetailsTotal.order' => function ($query) {
                $query->where('status', 'completed');
            }
        ])
            ->withSum(['orderDetailsTotal as total_revenue'], 'total')
            ->whereHas('orderDetailsTotal.order', function ($query) {
                $query->where('status', 'completed');
            })
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        // Lấy top 5 sản phẩm bán chạy nhất
        $topSellingProducts = Product::with([
            'orderDetailsTotal.order' => function ($query) {
                $query->where('status', 'completed');
            }
        ])
            ->withSum(['orderDetailsTotal as total_sold'], 'quantity') // Tính tổng số lượng bán
            ->whereHas('orderDetailsTotal.order', function ($query) {
                $query->where('status', 'completed');
            })
            ->orderByDesc('total_sold') // Sắp xếp theo tổng số lượng bán
            ->take(5) // Lấy 5 sản phẩm đầu tiên
            ->get();

        // Lấy top 5 sản phẩm lợi nhuận cao nhất
        $topProfitProducts = Product::with(['orderDetailsTotal.order', 'variants'])
            ->get()
            ->filter(function ($product) {
                $totalProfit = 0;

                foreach ($product->orderDetailsTotal as $detail) {
                    // Kiểm tra nếu `order` tồn tại
                    if ($detail->order && $detail->order->status === 'completed') {
                        $variant = $product->variants->firstWhere('id', $detail->variant_id);

                        if ($variant) {
                            $profit = ($detail->price - $variant->import_price) * $detail->quantity;
                            $totalProfit += $profit;
                        }
                    }
                }

                $product->total_profit = $totalProfit; // Gán tổng lợi nhuận
                return $totalProfit > 0; // Chỉ giữ lại sản phẩm có lợi nhuận > 0
            })
            ->sortByDesc('total_profit') // Sắp xếp theo lợi nhuận giảm dần
            ->take(5); // Lấy 5 sản phẩm đầu tiên

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
            'topSellingProducts',
            'topProfitProducts'
        ));
    }
}
