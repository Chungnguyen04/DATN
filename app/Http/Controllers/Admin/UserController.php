<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Sử dụng paginate để lấy danh sách người dùng với 5 bản ghi mỗi trang
        $users = User::paginate(5);
        // Truyền biến $users sang view
        return view('Admin.pages.users.list_user', compact('users'));
    }
    public function create()
    {
        $users = User::query()->pluck('id')->all();
        return view('Admin.pages.users.add_user', compact('users'));
    }
    public function store(Request $req)
    {
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // Kiểm tra email trùng lặp
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required',
        ], [
            'name.required' => 'Tên bắt buộc phải nhập',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại', // Thông báo khi email đã tồn tại
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'phone.required' => 'Số điện thoại bắt buộc',
            'type.required' => 'Vai trò bắt buộc phải nhập',
        ]);

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'phone' => $req->phone,
            'address' => $req->address,
            'type' => $req->type,
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

        return view('Admin.pages.users.edit_user', compact('user'));
    }

    public function update($id, Request $req ){
        $validated = $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required', // Kiểm tra email trùng lặp
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'address' => 'required',
            'type' => 'required',
        ], [
            'name.required' => 'Tên bắt buộc phải nhập',
            'email.required' => 'Email bắt buộc phải nhập',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại', // Thông báo khi email đã tồn tại
            'password.required' => 'Mật khẩu bắt buộc phải nhập',
            'phone.required' => 'Số điện thoại bắt buộc',
            'type.required' => 'Vai trò bắt buộc phải nhập',
        ]);

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => $req->password,
            'phone' => $req->phone,
            'address' => $req->address,
            'type' => $req->type,
        ];
        User::where('id',$id)->update($data);
        return redirect()->route('users.index')
            ->with('message', 'Sửa thành công');
    }


    public function delete($id)
    {
        $user = User::findOrFail($id); // Tìm người dùng theo ID, nếu không có thì báo lỗi
        $user->delete(); // Xóa người dùng
        return redirect()->route('users.index')
        ->with('message','Tài khoản đã được xóa thành công');
    }
}
