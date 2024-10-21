<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function apiLogin(Request $req): JsonResponse
    {
        // Xác thực dữ liệu đầu vào với thông báo lỗi tùy chỉnh
        $messages = [
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.regex' => 'Mật khẩu phải có chữ cái đầu là hoa, ít nhất một chữ cái viết thường và một số.',
        ];
    
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Z].+$/'
            ],
        ], $messages);
    
        // Kiểm tra lỗi xác thực
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
                'status_code' => 422
            ], 422);
        }
    
        // Lấy người dùng theo email
        $user = User::where('email', $req->email)->first();
        
        // Kiểm tra xem email có tồn tại không
        if (!$user) {
            // Email không tồn tại
            return response()->json([
                'message' => 'Email không tồn tại',
                'status_code' => 400
            ], 400);
        }
    
        // Kiểm tra mật khẩu
        if (!Hash::check($req->password, $user->password)) {
            // Email đúng nhưng mật khẩu sai
            return response()->json([
                'message' => 'Mật khẩu không đúng',
                'status_code' => 401
            ], 401);
        }
    
        // Đăng nhập thành công, tạo token cho người dùng
        $token = $user->createToken('authToken')->plainTextToken; // Tạo token
    
        return response()->json([
            'message' => 'Đăng nhập thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phonenumber' =>$user->phonenumber,
                'role' => $user->role,
            ],
            'token' => $token, // Trả về token
            'status_code' => 200
        ], 200);
    }

    public function apiRegister(Request $req): JsonResponse
{
    // Xác thực dữ liệu đầu vào với thông báo lỗi tùy chỉnh
    $messages = [
        'email.required' => 'Email là bắt buộc.',
        'email.email' => 'Email không hợp lệ.',
        'email.unique' => 'Email đã tồn tại.',
        'password.required' => 'Mật khẩu là bắt buộc.',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
        'password.regex' => 'Mật khẩu phải có chữ cái đầu là hoa, ít nhất một chữ cái viết thường và một số.',
        'confirmPassword.required' => 'Xác nhận mật khẩu là bắt buộc.',
        'confirmPassword.same' => 'Xác nhận mật khẩu không khớp.',
        'phonenumber.required' => 'Số điện thoại là bắt buộc.',
        'phonenumber.regex' => 'Số điện thoại không hợp lệ.',
    ];

    // Xác thực dữ liệu đầu vào
    $validator = Validator::make($req->all(), [
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:6',
            'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Z].+$/'
        ],
        'confirmPassword' => 'required|same:password',
        'phonenumber' => 'required|regex:/^[0-9]{10,15}$/' // Kiểm tra số điện thoại, có thể điều chỉnh theo yêu cầu
    ], $messages);

    // Kiểm tra lỗi xác thực
    if ($validator->fails()) {
        return response()->json([
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors(),
            'status_code' => 422
        ], 422);
    }

    // Kiểm tra xem có người dùng nào trong cơ sở dữ liệu chưa
    $isFirstUser = User::count() === 0;

    // Tạo dữ liệu người dùng
    $data = [
        'email' => $req->email,
        'password' => Hash::make($req->password), // Mã hóa mật khẩu
        'phonenumber' => $req->phonenumber,
        'role' => $isFirstUser ? 0 : 1, // Thiết lập vai trò: 0 cho admin, 1 cho user
    ];

    // Tạo người dùng mới
    $newUser = User::create($data);

    return response()->json([
        'message' => 'Đăng ký thành công',
        'user' => [
            'id' => $newUser->id,
            'email' => $newUser->email,
            'phonenumber' => $newUser->phonenumber,
            'role' => $newUser->role,
        ],
        'status_code' => 201
    ], 201);
}


    public function apiLogout(Request $req): JsonResponse
    {
        // Lấy người dùng hiện tại
        $user = $req->user();
        
        // Lấy danh sách token trước khi xóa
        $tokensBefore = $user->tokens()->get();

        // Kiểm tra nếu người dùng không có token
        if ($tokensBefore->isEmpty()) {
            return response()->json([
                'message' => 'Đăng xuất thất bại: Người dùng không có token',
                'status_code' => 400
            ], 400);
        }

        // Xóa tất cả token của người dùng hiện tại
        $user->tokens()->delete();

        // Làm mới danh sách token sau khi xóa
        $tokensAfter = $user->tokens()->get();

        return response()->json([
            'message' => 'Đăng xuất thành công',
            'tokens_before' => $tokensBefore,
            'tokens_after' => $tokensAfter,
            'status_code' => 200
        ], 200);
    }

}
