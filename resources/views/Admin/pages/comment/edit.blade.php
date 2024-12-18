@extends('admin.layouts.master')

@section('title')
Cập nhật đánh giá
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Cập nhật đánh giá</h4>
                </div>
                <!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tên người dùng</th>
                                        <th>Sản phẩm</th>
                                        <th>Nội dung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $commentById->user->name }}</td>
                                        <td>{{ optional($comment->product)->name ?? 'Không xác định' }}</td>
                                        <td>{{ $commentById->content }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="live-preview">
                            <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
                            <input type="hidden" name="order_id" value="{{ $comment->order_id }}">
                            <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
                            <input type="hidden" name="content" value="{{ $comment->content }}">
                            <div class="col-md-12">
                                <label for="" class="form-label">Trạng thái</label>
                                <select name="status" class="form-select" aria-label="Default select example">
                                    @if ($commentById->status === 'default')
                                    <option value="default" selected>Hiển thị</option>
                                    <option class="text-danger" value="hidden">Ẩn</option>
                                    @elseif ($commentById->status === 'hidden')
                                    <option value="hidden" selected>Ẩn</option>
                                    <option class="text-success" value="default">Hiển thị</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 pt-2">
                                <button type="button" id="btnUpdateComment" class="btn btn-primary">Submit</button>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div> <!-- end col -->
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let btnUpdateComment = document.querySelector('#btnUpdateComment');

        btnUpdateComment.addEventListener('click', function() {
            let status = document.querySelector('select[name="status"]').value;
            let commentId = '{{ $commentById->id }}';
            let data = {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PUT' // Laravel expects a PUT request
            };

            $.ajax({
                url: '{{ route("comments.update", $commentById )}}',
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: `Cập nhật đánh giá thành công`,
                            showConfirmButton: false,
                            timer: 2500
                        }).then(() => {
                                window.location.href = '{{ route("comments.index") }}';
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "warning",
                            title: `Đã xảy ra lỗi`,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: `Lỗi không thể cập nhật`,
                        text: `${xhr.responseJSON.message || error}`,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            });
        });
    });
</script>
@endsection 