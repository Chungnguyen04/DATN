<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment as ModelsComment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComment($productId, $variantId)
    {
        try {
            // Kiểm tra xem sản phẩm có tồn tại không
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sản phẩm không tồn tại.'
                ], Response::HTTP_NOT_FOUND);
            }

            // Lấy danh sách đánh giá theo product_id và variant_id
            $comments = ModelsComment::with(['user', 'product'])
                ->where('product_id', $productId)
                ->where('variant_id', $variantId) // Thêm điều kiện variant_id
                ->where('status', 'default')
                ->orderBy('id', 'desc')
                ->get();

            return $comments->isEmpty()
                ? response()->json([
                    'status' => false,
                    'message' => 'Không có đánh giá nào cho biến thể này của sản phẩm.'
                ], Response::HTTP_NOT_FOUND)
                : response()->json([
                    'status' => true,
                    'message' => 'Danh sách đánh giá đã được lấy thành công.',
                    'data' => $comments
                ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu',
                'errors' => [$e->getMessage()],
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function addComment(Request $request)
    {
        // Kiểm tra tính hợp lệ của dữ liệu đầu vào
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'product_id' => 'required|integer|exists:products,id',
            'variant_id' => 'required|integer|exists:variants,id', // Thêm variant_id
            'user_id' => 'required|integer|exists:users,id',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Kiểm tra xem đơn hàng có tồn tại và trạng thái "completed" không
        $order = Order::find($request->order_id);

        if (!$order || $order->status !== 'completed') {
            return response()->json([
                'status' => false,
                'message' => 'Chỉ có thể đánh giá khi đơn hàng đã hoàn thành'
            ], Response::HTTP_FORBIDDEN);
        }

        // Kiểm tra xem đã có đánh giá cho biến thể sản phẩm trong đơn hàng này hay chưa
        $existingComment = ModelsComment::where('order_id', $request->order_id)
            ->where('product_id', $request->product_id)
            ->where('variant_id', $request->variant_id) // Kiểm tra theo variant_id
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingComment) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ có thể đánh giá một lần cho mỗi biến thể sản phẩm'
            ], Response::HTTP_FORBIDDEN);
        }

        // Tạo đánh giá mới
        $comment = ModelsComment::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id, // Lưu variant_id
            'user_id' => $request->user_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'status' => 'default' // Thiết lập trạng thái mặc định là 'default'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm đánh giá thành công.',
            'data' => $comment,
        ], Response::HTTP_CREATED);
    }
}
