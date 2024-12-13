<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng doanh thu của tháng hiện tại
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalRevenueThisMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $currentYear)
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
        $daxacnhan = Order::where('status', 'confirmed')->count();
        $danggiao = Order::where('status', 'shipping')->count();

        $totalCompletedOrders = Order::where('status', 'completed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $giaohuy = Order::where('status', 'cancelled')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $giaothatbai = Order::where('status', 'failed')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $giaothanhcong = Order::where('status', 'delivering')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();


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
            ->whereHas('orderDetailsTotal.order', function ($query) use ($currentMonth, $currentYear) {
                $query->where('status', 'completed')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear);
            })
            ->orderByDesc('total_sold') // Sắp xếp theo tổng số lượng bán
            ->take(5) // Lấy 5 sản phẩm đầu tiên
            ->get();

        // Lấy top 5 sản phẩm lợi nhuận cao nhất
        $topProfitProducts = Product::with(['orderDetailsTotal.order', 'variants'])
            ->whereHas('orderDetailsTotal.order', function ($query) use ($currentMonth, $currentYear) {
                $query->where('status', 'completed')
                    ->whereMonth('created_at', $currentMonth)
                    ->whereYear('created_at', $currentYear);
            })
            ->get()
            ->map(function ($product) {
                $totalProfit = 0;

                foreach ($product->orderDetailsTotal as $detail) {
                    if ($detail->order && $detail->order->status === 'completed') {
                        $variant = $product->variants->firstWhere('id', $detail->variant_id);

                        if ($variant) {
                            $profit = ($detail->price - $variant->import_price) * $detail->quantity;
                            $totalProfit += $profit;
                        }
                    }
                }

                $product->total_profit = $totalProfit; // Gán tổng lợi nhuận vào sản phẩm
                return $product;
            })
            ->filter(function ($product) {
                return $product->total_profit > 0; // Chỉ giữ sản phẩm có lợi nhuận > 0
            })
            ->sortByDesc('total_profit') // Sắp xếp theo lợi nhuận giảm dần
            ->take(5); // Lấy 5 sản phẩm đầu tiên

        // Trả tất cả dữ liệu về View trong một lần
        return view('admin.pages.dashboard', compact(
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
