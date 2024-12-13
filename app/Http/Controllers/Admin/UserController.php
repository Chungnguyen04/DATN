<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('province', 'district', 'ward')->paginate(5);
        return view('admin.pages.users.list_user', compact('users'));
    }

    public function create()
    {
        $users = User::query()->pluck('id')->all();
        $data['provinces']  = Province::all();
        $data['districts']  = District::all();
        $data['wards']      = Ward::all();
        return view('admin.pages.users.add_user', compact('users', 'data'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Kiểm tra email trùng lặp
            'password' => 'required|string|min:6',
            'type' => 'required',
        ], [
            'name.required' => 'Tên bắt buộc phải nhập',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại', // Thông báo khi email đã tồn tại
            'type.required' => 'Vai trò bắt buộc phải nhập',
        ]);

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'phone' => $req->phone,
            'address' => $req->address,
            'type' => $req->type,
            'province_id' => $req->province_id,
            'district_id' => $req->district_id,
            'ward_id' => $req->ward_id,
        ];
        User::create($data);

        // Lấy danh sách người dùng sau khi thêm mới
        return redirect()->route('users.index')->with('message', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('message', 'Người dùng không tồn tại');
        }

        $data['provinces']  = Province::all();
        $data['districts']  = District::all();
        $data['wards']      = Ward::all();

        return view('admin.pages.users.edit_user', compact('user', 'data'));
    }

    public function update($id, Request $req)
    {
        // Xác thực dữ liệu
        $validated = $req->validate([
            'type' => 'required',
        ], [
            'type.required' => 'Vai trò bắt buộc phải nhập',
        ]);
    
        // Lấy user hiện tại
        $user = User::findOrFail($id);
    
        // Cập nhật dữ liệu cơ bản
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'phone' => $user->phone,
            'address' => $user->address,
            'type' => $req->type,
            'province_id' => $user->province_id,
            'district_id' => $user->district_id,
            'ward_id' => $user->ward_id,
        ];
    
        // Kiểm tra nếu người dùng có nhập mật khẩu mới, thì mã hóa và cập nhật mật khẩu
        if ($req->filled('password')) {
            $data['password'] = Hash::make($req->password);
        }
    
        // Thực hiện cập nhật dữ liệu
        $user->update($data);
    
        return redirect()->route('users.index')->with('message', 'Cập nhật thành công');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID, nếu không có thì báo lỗi

        // Kiểm tra loại tài khoản
        if ($user->type === 'admin') {
            return redirect()->route('users.index')
                ->with('message', 'Không thể xóa tài khoản admin');
        }
        
        // Thực hiện xóa nếu là member
        $user->delete(); // Xóa người dùng
        
        return redirect()->route('users.index')
            ->with('message', 'Tài khoản đã được xóa thành công');
    }
}
