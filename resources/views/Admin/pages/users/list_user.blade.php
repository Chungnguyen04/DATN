@extends('Admin.layouts.master') <!-- Cập nhật theo layout người dùng cuối nếu có -->

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Danh sách người dùng</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <a href="{{ route('users.create') }}" class="btn btn-primary m-3">Thêm mới</a>
                                    <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Tên người dùng</th>
                                                <th scope="col">Tài khoản</th>
                                                <th scope="col">Số điện thoại</th>
                                                <th scope="col">Địa chỉ</th>
                                                <th scope="col">Vai trò</th>
                                                <th scope="col" style="width: 150px;">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($users) && $users->count() > 0)
                                                @foreach ($users as $key => $item)
                                                    <tr data-id-tr="{{ $item->id }}">
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->email }}</td>
                                                        <td>{{ $item->phone }}</td>
                                                        <td>{{ $item->address }}</td>
                                                        <td>{{ $item->type }}</td>
                                                        <td>
                                                            <a style="margin: 0 5px;" href="{{ route('users.edit', $item->id) }}" class="link-primary">
                                                                <i class="ri-settings-4-line" style="font-size:18px;"></i>
                                                            </a>
                                                            <a style="margin: 0 5px; cursor: pointer;" class="link-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                                                <i class="ri-delete-bin-5-line" style="font-size:18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Xóa User -->
                                                    <div id="deleteModal{{ $item->id }}" class="modal fade" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                               trigger="loop"
                                                                               colors="primary:#f7b84b,secondary:#405189"
                                                                               style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4">
                                                                        <h4 class="mb-3">Bạn muốn xóa tài khoản này?</h4>
                                                                        <h5 class="mb-3">'{{ $item->name }}'</h5>
                                                                        <p class="text-muted mb-4"> Tài khoản này sẽ bị xóa vĩnh viễn khỏi hệ thống.</p>
                                                                        <div class="hstack gap-2 justify-content-center">
                                                                            <button type="button" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal">
                                                                                Hủy
                                                                            </button>
                                                                            <form action="{{ route('users.delete', $item->id) }}" method="POST" style="display:inline;">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">Không có người dùng nào</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links('pagination::bootstrap-4') }} <!-- Sử dụng phân trang Bootstrap 5 -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div> <!-- end col -->
@endsection
