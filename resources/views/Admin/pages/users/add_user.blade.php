@extends('Admin.layouts.master')

@section('title')
    Thêm mới người dùng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thêm mới người dùng</h4>
                    </div>

                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="live-preview">
                                
                                <div class="col-md-6 mt-3">
                                    <label for="userName" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" id="userName" placeholder="Nhập tên người dùng...">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userEmail" class="form-label">Tài khoản</label>
                                    <input type="email" class="form-control" value="{{ old('email') }}" name="email" id="userEmail" placeholder="Nhập email...">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userPassword" class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control" name="password" id="userPassword" placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userPhone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" value="{{ old('phone') }}" name="phone" id="userPhone" placeholder="Nhập số điện thoại...">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" value="{{ old('address') }}" name="address" id="userAddress" placeholder="Nhập địa chỉ...">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userType" class="form-label">Vai trò</label>
                                    <select name="type" id="userType" class="form-select">
                                        <option value="admin" @selected(old('type') == 'admin')>admin</option>
                                        <option value="member" @selected(old('type') == 'member')>member</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4 text-start">
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Quay lại</a>
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
