@extends('Admin.layouts.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="" style="min-height: 950px;">
                    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-18 fw-semibold m-0">Thêm mới người dùng</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <label for="" class="form-label"> Tên Người Dùng </label>
                                        <input type="text" class="form-control" name="name">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <label for="" class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <label for="" class="form-label">Mật Khẩu</label>
                                        <input type="text" class="form-control" name="password">
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <label for="" class="form-label">Số Điện Thoại</label>
                                        <input type="text" class="form-control" name="phone">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <label for="" class="form-label">Địa Chỉ</label>
                                        <input type="text" class="form-control" name="address">
                                        @error('address')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type" class="form-label">Vai Trò</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="admin">Admin</option>
                                                    <option value="member">Member</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-success">Thêm mới</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
