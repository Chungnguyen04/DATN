<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoucherController extends Controller
{
    // Lấy ra danh sách voucher và voucher chưa sử dụng
    public function getVoucherList(Request $request)
    {
        // Lấy tất cả các voucher chưa hết hạn
        $vouchers = Voucher::where('end_date', '>', now())
            ->orderBy('id', 'desc')
            ->get();
    
        if ($vouchers->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Không có voucher nào.'
            ], Response::HTTP_NOT_FOUND);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách voucher thành công',
            'data' => $vouchers
        ], Response::HTTP_OK);
    }

    // Lấy danh sách voucher đã lưu bởi người dùng
    public function getUserVouchers()
    {
        // Lấy user_id từ token
        $userId = Auth::id();

        // Lấy danh sách voucher đã lưu bởi người dùng
        $userVouchers = UserVoucher::where('user_id', $userId)
            ->with('voucher') // Eager load voucher details
            ->get()
            ->pluck('voucher'); // Pluck the voucher details

        return response()->json($userVouchers, Response::HTTP_OK);
    }

    // Lưu voucher cho người dùng
    public function storeUserVoucher(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Không có quyền truy cập.'], 401);
        }

        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher) {
            return response()->json(['status' => false, 'message' => 'Voucher không tồn tại.'], 404);
        }

        // Kiểm tra xem người dùng đã có voucher này chưa
        $existing = UserVoucher::where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->first();

        // Nếu voucher đã được lưu, trả về thông báo
        if ($existing) {
            return response()->json(['status' => false, 'message' => 'Bạn đã lưu voucher này rồi.'], 400);
        }

        // Lưu voucher cho người dùng
        UserVoucher::create([
            'user_id' => $user->id,
            'voucher_id' => $voucher->id,
        ]);

        return response()->json(['status' => true, 'message' => 'Lưu voucher thành công!']);
    }

    // Kiểm tra sử dụng voucher theo đơn hàng
    public function checkVoucher(Request $request)
    {
        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher) {
            return response()->json([
                'status' => false,
'message' => 'Voucher không tồn tại.',
            ], Response::HTTP_NOT_FOUND);
        }

        

        if ($request->total_price < $voucher->discount_min_price) {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng của bạn không đủ điều kiện để sử dụng voucher này!',
            ], Response::HTTP_OK);
        }

        // Giảm số lượng sử dụng của voucher
        $voucher->total_uses -= 1;
        $voucher->save();

        return response()->json([
            'status' => true,
            'message' => 'Kiểm tra voucher thành công.',
            'data' => $voucher
        ], Response::HTTP_OK);
    }
}