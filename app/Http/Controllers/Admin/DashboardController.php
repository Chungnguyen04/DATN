<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
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
 'products.id', // Chỉ định rõ ràng bảng
 'products.name',
 'products.code', // Giả định bạn có trường code
 DB::raw('SUM(order_details.price * order_details.quantity) as profit')
)
->join('order_details', 'products.id', '=', 'order_details.order_id') // Sửa thành product_id
->groupBy('products.id', 'products.name', 'products.code')
->orderByDesc('profit')
->take(5)
->get();

return view('Admin.pages.dashboard', compact('totalOrders', 'totalRevenueThisMonth', 'topRevenueProducts', 'topProducts','topProfitProducts'));
    }
}
