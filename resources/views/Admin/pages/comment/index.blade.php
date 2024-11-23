@extends('admin.layouts.master')

@section('title')
Danh sách đánh giá
@endsection

@section('content')
<style>
    .status-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 5px;
    }
</style>
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Danh sách đánh giá</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="table-responsive table-card">
                                {{-- @if($comment = '') --}}
                                <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên người dùng</th>
                                            <th>Sản phẩm</th>
                                            <th>Nội dung</th>
                                            <th>Đánh giá</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($comments))
                                        @foreach($comments as $key => $comment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $comment->user->name }}</td>
                                            <td>{{ $comment->product->name }}</td>
                                            <td>{{ $comment->content }}</td>
                                            <td>
                                                @for ($i = 1; $i <= $comment->rating; $i++)
                                                    <i class="ri-star-fill" style="color: gold;"></i> <!-- Sao đầy -->
                                                @endfor
                                            </td>
                                            <td>
                                                @if ($comment->status === 'default')
                                                    <span class="status-dot" style="background-color: green;"></span> Hiển thị
                                                @else
                                                    <span class="status-dot" style="background-color: red;"></span> Ẩn
                                                @endif
                                            </td>
                                            <td><a class="btn btn-info" href="{{ route('comments.edit',$comment->id) }}">Chỉnh sửa</a></td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{-- @else
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="p-5">
                                        Không có đánh giá nào
                                    </div>
                                </div>
                                @endif --}}
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
                <div class="d-flex justify-content-center align-items-center">
                    <div>{{ $comments->links('pagination::bootstrap-4') }}</div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div>
</div> <!-- end col -->
@endsection

@section('script')

@endsection