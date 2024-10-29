<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment as ModelsComment;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class Comment extends Controller
{
    public function getComment($productId){
        try {
            $comments = ModelsComment::with([
                'user',
                'product'
            ])
            ->where('product_id',$productId)
            ->orderBy('id','desc')
            ->get();
            if ($comments->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không có bình luận nào cho sản phẩm này.'
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'status' => true,
                'message' => 'Danh sách bình luận đã được lấy thành công.',
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
    public function addComment(Request $request){
            $comment = ModelsComment::query()->create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Thêm bình luận thành công.',
                'data'=>$comment,
            ], Response::HTTP_CREATED);
    }
}
