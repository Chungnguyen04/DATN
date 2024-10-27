@extends('Admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('content')
<div  class="p-4" style="min-height: 950px;">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
         <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Thêm mới User</h4>
       </div>
    </div>
    <form action="{{  route('editPost', $user->id) }}" method="POST"
    enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <label for="" class="form-label"> Name </label>
            <input type="text" class="form-control" name="name"  value="{{ $user->name }}">
            @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <label for="" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" value="{{ $user->email }}">
            @error('email')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <label for="" class="form-label">Password</label>
            <input type="text" class="form-control" name="password" value="{{ $user->password }}">
            @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <label for="" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
            @error('phone')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <label for="" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $user->address }}">
            @error('address')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
       
       
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò người dùng</label>
            <select name="role" id="role" class="form-select">
                <option value="1" {{ $user->role == 0 ? 'selected' : '' }}>Admin</option>
                <option value="2" {{ $user->role == 1 ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <hr>
        <button type="submit" class="btn btn-success">Sửa mới</button>
    </form>
    </div>
@endsection
