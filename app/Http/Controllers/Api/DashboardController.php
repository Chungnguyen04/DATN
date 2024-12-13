<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function filterMonthAndYear(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $totalCompletedOrders = Order::where('status', 'completed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
        $giaohuy = Order::where('status', 'cancelled')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
        $giaothatbai = Order::where('status', 'failed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();
        $giaothanhcong = Order::where('status', 'delivering')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->count();

        return response()->json([
            'hoanthanh' => $totalCompletedOrders,
            'giaohuy' => $giaohuy,
            'giaothatbai' => $giaothatbai,
            'giaothanhcong' => $giaothanhcong,
        ]);
    }
}
