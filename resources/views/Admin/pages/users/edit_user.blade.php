@extends('Admin.layouts.master')

@section('title')
    Cập nhật người dùng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Cập nhật người dùng</h4>
                    </div><!-- end card header -->

                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="live-preview">
                                <!-- Tên Người Dùng -->
                                <div class="col-md-6 mt-3">
                                    <label for="userName" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" name="name" id="userName"
                                        placeholder="Nhập tên người dùng..." value="{{ $user->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mt-3">
                                    <label for="userEmail" class="form-label">Tài khoản</label>
                                    <input type="email" class="form-control" name="email" id="userEmail"
                                        placeholder="Nhập email..." value="{{ $user->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Mật Khẩu -->
                                <div class="col-md-6 mt-3">
                                    <label for="userPassword" class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control" name="password" id="userPassword"
                                        placeholder="Nhập mật khẩu..." value="{{ $user->password }}">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Số Điện Thoại -->
                                <div class="col-md-6 mt-3">
                                    <label for="userPhone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="userPhone"
                                        placeholder="Nhập số điện thoại..." value="{{ $user->phone }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Địa Chỉ -->
                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" id="userAddress"
                                        placeholder="Nhập địa chỉ..." value="{{ $user->address }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Vai Trò -->
                                <div class="col-md-6 mt-3">
                                    <label for="userType" class="form-label">Vai trò</label>
                                    <select name="type" id="userType" class="form-select">
                                        <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>admin
                                        </option>
                                        <option value="member" {{ $user->type == 'member' ? 'selected' : '' }}>member
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="text-start">
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Quay lại</a>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
  
@endsection
