<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function apiRegister(Request $req): JsonResponse
    {
        $messages = [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'confirmPassword.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirmPassword.same' => 'Xác nhận mật khẩu không khớp.',
        ];

        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'confirmPassword' => 'required|same:password',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
                'status_code' => 422
            ], 422);
        }

        $isFirstUser = User::count() === 0;

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ];

        $newUser = User::create($data);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => [
                'id' => $newUser->id,
                'name' => $newUser->name,
                'email' => $newUser->email,
            ],
            'status_code' => 201
        ], 201);
    }

    public function apiLogin(Request $request)
    {
        $messages = [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là bắt buộc.',
        ];

        // Kiểm tra tính hợp lệ của dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
                'status_code' => 422
            ], 422);
        }

        // Tìm kiếm người dùng theo email
        $user = User::where('email', $request->email)->first();

        // Kiểm tra nếu người dùng không tồn tại
        if (!$user) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Email không tồn tại',
            ], 401);
        }

        // Lấy thông tin xác thực
        $credentials = $request->only('email', 'password');

        // Kiểm tra thông tin đăng nhập
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status_code' => 401,
                'message' => 'Tài khoản hoặc mật khẩu không đúng',
            ], 401);
        }

        // Tạo token cho người dùng
        $token = $user->createToken('authToken')->plainTextToken;

        // Trả về thông tin đăng nhập thành công
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'status_code' => 200,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function apiLogout(Request $req): JsonResponse
    {
        $user = $req->user();
        $tokensBefore = $user->tokens()->get();

        if ($tokensBefore->isEmpty()) {
            return response()->json([
                'message' => 'Đăng xuất thất bại: Người dùng không có token',
                'status_code' => 400
            ], 400);
        }

        $user->tokens()->delete();
        $tokensAfter = $user->tokens()->get();

        return response()->json([
            'message' => 'Đăng xuất thành công',
            'tokens_before' => $tokensBefore,
            'tokens_after' => $tokensAfter,
            'status_code' => 200
        ], 200);
    }
}
