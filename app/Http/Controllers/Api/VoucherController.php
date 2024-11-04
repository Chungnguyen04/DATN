<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VoucherController extends Controller
{
    // Lấy ra danh sách voucher và voucher chưa sử dụng
    public function getVoucherList(Request $request)
    {
        // Lấy ID của các voucher mà người dùng đã lưu (sử dụng)
        $usedVoucherIds = UserVoucher::where('user_id', $request->user_id)->pluck('voucher_id');

        // Lấy các voucher chưa được người dùng sử dụng
        $vouchers = Voucher::whereNotIn('id', $usedVoucherIds)->orderBy('id', 'desc')->get();

        if ($vouchers->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => 'Lấy danh sách voucher thành công',
                'data' => $vouchers
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Không có voucher nào chưa sử dụng.'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    // Lưu voucher cho người dùng
    public function storeUserVoucher(Request $request)
    {
        $voucher = Voucher::find($request->voucher_id);

        if (!$voucher) {
            return response()->json(['status' => false, 'message' => 'Voucher không tồn tại.'], 404);
        }

        // Kiểm tra xem người dùng đã có voucher này chưa
        $existing = UserVoucher::where('user_id', $request->user_id)
            ->where('voucher_id', $voucher->id)
            ->first();

        if ($existing) {
            return response()->json(['status' => false, 'message' => 'Bạn đã lưu voucher này rồi.'], 400);
        }

        // Lưu voucher cho người dùng
        UserVoucher::create([
            'user_id' => $request->user_id,
            'voucher_id' => $voucher->id,
        ]);

        return response()->json(['status' => true, 'message' => 'Lưu voucher thành công!']);
    }

    // Check sử dụng voucher theo đơn hàng
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

        return response()->json([
            'status' => true,
            'message' => 'Kiểm tra voucher thành công.',
            'data' => $voucher
        ], Response::HTTP_OK);
    }

}
