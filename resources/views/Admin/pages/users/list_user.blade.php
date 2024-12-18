@extends('admin.layouts.master') <!-- Cập nhật theo layout người dùng cuối nếu có -->

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
                                                <th scope="col">Thông tin bổ sung</th>
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
                                                        <td style="max-width: 200px;">
                                                            <span style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;display: inline-block;width: 200px;"><b>{{ $item->address }}</b></span>
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                <li>Tỉnh / Thành phố: {{ $item->province->name ?? 'Chưa cập nhật' }}</li>
                                                                <li>Quận / Huyện: {{ $item->district->name ?? 'Chưa cập nhật' }}</li>
                                                                <li>Phường / Xã: {{ $item->ward->name ?? 'Chưa cập nhật' }}</li>
                                                            </ul>
                                                        </td>
                                                        <td>{{ $item->type }}</td>
                                                        <td>
                                                            <a style="margin: 0 5px;" href="{{ route('users.edit', $item->id) }}" class="link-primary">
                                                                <i class="ri-settings-4-line" style="font-size:18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
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
