<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment as ModelsComment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class Comment extends Controller
{
    public function getComment($productId)
    {
        try {
            $comments = ModelsComment::with([
                'user',
                'product'
            ])
                ->where('product_id', $productId)
                ->where('status','default')
                ->orderBy('id', 'desc')
                ->get();
            if ($comments->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không có đánh giá nào cho sản phẩm này.'
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
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


    public function checkCommentForOrder($userId, $orderId)
    {
        $order = Order::findOrFail($orderId);
        if(empty($order)){
            return response()->json([
                'status' => true,
                'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($order->status !== 'completed') {
            return response()->json([
                'status' => true,
                'message' => 'Chỉ có thể đánh giá khi đơn hàng đã hoàn thành'
            ], Response::HTTP_FORBIDDEN);
        }

        $existingComment = ModelsComment::where('order_id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if ($existingComment) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ có thể đánh giá một lần cho mỗi đơn hàng'
            ], Response::HTTP_FORBIDDEN);
        }
        return response()->json([
            'status'=>true,
            'message' => "Chưa có đánh giá nào, hãy đánh giá đơn hàng"
        ]);
    }


    public function checkCommentForProduct($userId, $productId)
    {
        $product = Product::findOrFail($productId);
        if(empty($product)){
            return response()->json([
                'status' => true,
                'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu'
            ], Response::HTTP_FORBIDDEN);
        }
        $existingComment = ModelsComment::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($existingComment) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chỉ có thể đánh giá một lần cho mỗi sản phẩm'
            ], Response::HTTP_FORBIDDEN);
        }
        return response()->json([
            'status'=>true,
            'message' => "Chưa có đánh giá nào, hãy đánh giá sản phẩm"
        ]);
    }

    public function addComment(Request $request)
    {

        $comment = ModelsComment::query()->create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'content' => $request->content,
            'rating' => $request->rating
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm đánh giá thành công.',
            'data' => $comment,
        ], Response::HTTP_CREATED);
    }

}
