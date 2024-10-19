<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function listUser()
{
    $users = User::all();
    return response()->json([
        'success' => true,
        'data' => $users
    ], 200); 
}

public function addUser()
{
    
    $userIds = User::query()->pluck('id')->all();
    return response()->json([
        'success' => true,
        'data' => $userIds
    ], 200);
}


public function addPost(Request $req)
{
    // Xác thực dữ liệu đầu vào
    try {
        $validated = $req->validate([
            'name' => 'nullable|string|max:255',  // Cho phép không có tên
            'email' => 'required|string|email|max:255|unique:users,email', // Kiểm tra email trùng lặp
            'password' => 'required|string|min:6',
            'phonenumber' => 'required|unique:users,phonenumber', // Kiểm tra số điện thoại trùng lặp
            'role' => 'required',
        ], [
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại', // Thông báo khi email đã tồn tại
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'phonenumber.required' => 'Số điện thoại bắt buộc',
            'phonenumber.unique' => 'Số điện thoại đã tồn tại', // Thông báo khi số điện thoại đã tồn tại
            'role.required' => 'Vai trò bắt buộc phải nhập',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Trả về phản hồi JSON với mã lỗi 401 khi có lỗi xác thực
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $e->errors()  // Lấy danh sách lỗi xác thực
        ], 401);
    }

    // Tạo người dùng mới
    $data = [
        'name' => $req->name ?? 'Unnamed User', // Nếu không có tên, đặt tên mặc định
        'email' => $req->email,
        'password' => bcrypt($req->password), // Mã hóa mật khẩu
        'phonenumber' => $req->phonenumber,
        'role' => $req->role,
    ];

    // Tạo người dùng trong cơ sở dữ liệu
    User::create($data);

    // Lấy danh sách người dùng sau khi thêm mới
    $users = User::all();

    // Trả về phản hồi JSON thành công
    return response()->json([
        'success' => true,
        'message' => 'Thêm mới thành công',
        'data' => $users
    ], 201); // Mã trạng thái 201 là "Created"
}


public function edit($id)
{
    // Tìm người dùng theo ID
    $user = User::find($id);

    // Kiểm tra nếu người dùng không tồn tại
    if (!$user) {
        // Trả về phản hồi JSON với mã lỗi 404
        return response()->json([
            'success' => false,
            'message' => 'Người dùng không tồn tại'
        ], 404); // Mã trạng thái 404 là "Not Found"
    }

    // Trả về phản hồi JSON với thông tin người dùng bao gồm mật khẩu
    return response()->json([
        'success' => true,
        'message' => 'Thông tin người dùng',
        'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phonenumber' => $user->phonenumber,
            'role' => $user->role,
            'password' => $user->password, // Bao gồm mật khẩu
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]
    ], 200); // Mã trạng thái 200 là "OK"
}


public function editPost($id, Request $req)
{
    // Ghi log ID người dùng đang chỉnh sửa
    Log::info('Editing user with ID: ' . $id);

    // Xác thực dữ liệu đầu vào
    try {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Kiểm tra email trùng lặp, ngoại trừ bản ghi hiện tại
            'password' => 'required|string|min:6',
            'phonenumber' => 'required|unique:users,phonenumber,' . $id, // Kiểm tra số điện thoại trùng lặp, ngoại trừ bản ghi hiện tại
            'role' => 'required',
        ], [
            'name.required' => 'Tên bắt buộc phải nhập',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại', // Thông báo khi email đã tồn tại
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'phonenumber.required' => 'Số điện thoại bắt buộc',
            'phonenumber.unique' => 'Số điện thoại đã tồn tại', // Thông báo khi số điện thoại đã tồn tại
            'role.required' => 'Vai trò bắt buộc phải nhập',
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Ghi log lỗi xác thực
        Log::error('Validation failed: ', $e->errors());
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $e->errors() // Trả về lỗi xác thực
        ], 422); // Mã trạng thái 422 là "Unprocessable Entity"
    }

    // Cập nhật người dùng
    $data = [
        'name' => $req->name,
        'email' => $req->email,
        'password' => bcrypt($req->password), // Mã hóa mật khẩu
        'phonenumber' => $req->phonenumber,
        'role' => $req->role,
    ];

    // Cập nhật thông tin người dùng
    User::where('id', $id)->update($data);

    // Trả về phản hồi JSON thành công
    return response()->json([
        'success' => true,
        'message' => 'Sửa thành công',
        'data' => User::find($id) // Trả về thông tin người dùng đã được cập nhật
    ], 200); // Mã trạng thái 200 là "OK"
}


public function deleteUser(Request $req)
{
    // Kiểm tra xem ID có tồn tại không
    $user = User::find($req->id);
    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Người dùng không tồn tại',
        ], 404); // Mã trạng thái 404 là "Not Found"
    }
    // Xóa người dùng
    $user->delete();

    // Trả về phản hồi JSON thành công
    return response()->json([
        'success' => true,
        'message' => 'Xóa thành công',
    ], 200); // Mã trạng thái 200 là "OK"
}



}
