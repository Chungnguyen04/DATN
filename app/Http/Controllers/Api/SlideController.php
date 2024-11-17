<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class SlideController extends Controller
{
    // Lấy danh sách các sliders có phân trang
    public function getAllSlider(Request $request)
{
    try {
        $sliders = Slider::select('title', 'image', 'link') // Chỉ trả về các trường cần thiết
                        ->orderBy('id', 'DESC')
                        ->paginate(5);

        if ($sliders->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Không có sliders nào!',
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => true,
            'message' => 'Danh sách sliders đã được lấy',
            'data' => $sliders
        ], Response::HTTP_OK);

    } catch (QueryException $e) {
        return response()->json([
            'status' => false,
            'message' => 'Lỗi cơ sở dữ liệu',
            'errors' => [$e->getMessage()],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Lỗi hệ thống khi truy xuất dữ liệu',
            'errors' => [$e->getMessage()],
            'code' => $e->getCode()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}


    // Trả về thông tin của một slider cụ thể
    public function getSliderById($id)
    {
        try {
            $slider = Slider::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Thông tin slider đã được lấy',
                'data' => $slider
            ], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Slider không tồn tại',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu',
                'errors' => [$e->getMessage()],
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

