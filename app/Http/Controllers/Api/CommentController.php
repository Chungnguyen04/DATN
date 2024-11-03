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
    public function getComment(Request $request)
    {
        try {
            // Lấy `product_id` từ body của yêu cầu
            $productId = $request->input('product_id');
            $variantId = $request->input('variant_id');
    
            // Lấy thông tin người dùng đã xác thực từ token
            $user = $request->user();
    
            // Kiểm tra xem sản phẩm có tồn tại không
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sản phẩm không tồn tại.'
                ], Response::HTTP_NOT_FOUND);
            }
    
            // Lấy tất cả các bình luận cho sản phẩm này từ người dùng đã xác thực và bao gồm thông tin biến thể
            $comments = ModelsComment::with(['variant', 'user']) // Bao gồm thông tin variant và user
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->where('status', 'default')
                ->orderBy('id', 'desc')
                ->get();
    
            // Chuẩn bị phản hồi
            $response = $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'rating' => $comment->rating,
                    'created_at' => $comment->created_at,
                    'user' => [
                        'id' => $comment->user->id,
                        'name' => $comment->user->name,
                    ],
                ];
            });
    
            return response()->json([
                'status' => true,
                'message' => 'Danh sách bình luận đã được lấy thành công.',
                'data' => $response
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