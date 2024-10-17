@extends('Admin.layouts.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
<div  class="p-4" style="min-height: 950px;">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
         <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Thêm mới User</h4>
       </div>
    </div>
    <form action="{{ route('addPost')}}" method="POST"
    enctype="multipart/form-data" >
        @csrf
        <div class="row">
            <label for="" class="form-label"> Name </label>
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
            <label for="" class="form-label">Password</label>
            <input type="text" class="form-control" name="password">
            @error('password')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <label for="" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phonenumber">
            @error('phonenumber')
            <p class="text-danger">{{ $message }}</p>
        @enderror
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="1">Admin</option>
                        <option value="2">User</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success">Thêm mới</button>
    </form>
    </div>

@endsection
