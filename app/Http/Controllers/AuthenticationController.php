<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(){
        return view('login');
    }
    public function postLogin(Request $req){
        $req->validate([
            'email' => 'required|email', // Sử dụng chuỗi với dấu |
            'password' => 'required|string|min:6', // Sử dụng chuỗi với dấu |
            ],[
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Password không được để trống'
            ]);
            
        if(Auth::attempt([
            'email' => $req->email,
            'password' => $req->password,
        ])) {
           return redirect()->route('Admin.pages.users.list_user');
        }else{
            return redirect()->back()->with('message', 'Đăng nhập không thành công');
        }

    }

    public function register(){
      return view('register');
    }

    public function postRegister(Request $req){
        $check = User::where('email', $req->email)->exists();
        
        if($check){
            return redirect()->back()->with([
                'message' => 'Tài khoản đã tồn tại'
            ]);
        }else{
            $data =[
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'phonenumber'=>$req->phonenumber,
                
            ];
            $newUser = User::create($data);   
            return redirect()->route('login')->with([ // Để tạm thành login / cắt giao diện đổi thành người dùng
                'message' => 'Đăng ký thành công'
           ]);
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('message', 'Đăng xuất thành công');
    }
}
