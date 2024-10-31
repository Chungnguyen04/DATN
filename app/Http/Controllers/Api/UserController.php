<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    // Lấy thông tin người dùng
    public function getUserInfo(Request $request)
    {
        try {
            // Lấy thông tin người dùng từ token
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Người dùng không xác thực!'
                ], Response::HTTP_UNAUTHORIZED);
            }

            return response()->json([
                'status' => true,
                'message' => 'Lấy thông tin người dùng thành công.',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi lấy thông tin người dùng.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Cập nhật thông tin người dùng
    public function updateUser(Request $request)
    {
        try {
            // Lấy thông tin người dùng từ token
            $user = auth()->user();
    
            if (!$user || !$user instanceof \App\Models\User) {
                return response()->json([
                    'status' => false,
                    'message' => 'Người dùng không xác thực!'
                ], Response::HTTP_UNAUTHORIZED);
            }
    
            // Xác thực dữ liệu đầu vào
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone' => 'required|string|regex:/^0\d{3} \d{3} \d{3}$/',
                'address' => 'required|string|max:255',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Dữ liệu không hợp lệ!',
                    'errors' => $validator->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
    
            // Cập nhật thông tin người dùng
            $validatedData = $validator->validated();
            $user->update($validatedData);
    
            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin người dùng thành công.',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật thông tin người dùng.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}