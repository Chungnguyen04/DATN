@extends('Admin.layouts.master')

@section('title')
    Danh sách user
@endsection

@section('content')

<br>
<div class="p-4" style="height: 950px; width: 100%; ">
    
    <h4 class="text-primary mb-4">Danh sách user</h4>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <a href="{{ route('Admin.pages.users.add_user') }}">
        <button class="btn btn-info">Thêm mới</button>
    </a>
    
    <table class="table mt-3">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($users) && $users->count() > 0)
                @foreach ($users as $item)
                    <tr>
                        <th scope="row">{{ $item->id }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->password }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->address }}</td>
                        <td>{{ $item->role }}</td>
                        <td>
                            <a href="{{ route('Admin.pages.users.edit_user', $item->id) }}">
                                <button class="btn btn-info">Sửa</button>
                            </a>
                            <form action="/delete/{{ $item->id }}" method="POST" style="display:inline;" onclick="return confirm('Bạn có muốn xóa tài khoản ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <!-- Hiển thị các liên kết phân trang -->
                <nav aria-label="Page navigation example">
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }} <!-- Sử dụng Bootstrap 5 cho phân trang -->
                    </div>
                </nav>
            @else
                <tr>
                    <td colspan="8">Không có dữ liệu người dùng nào.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection
