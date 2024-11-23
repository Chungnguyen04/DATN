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
                                        <td>{{ $commentById->product->name }}</td>
                                        <td>{{ $commentById->content }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="live-preview">
                        <form method="POST" action="{{ route('comments.update',$comment) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="user_id" value="{{ $comment->user_id }}">
                            <input type="hidden" name="order_id" value="{{ $comment->order_id }}">
                            <input type="hidden" name="product_id" value="{{ $comment->product_id }}">
                            <input type="hidden" name="content" value="{{ $comment->content }}">
                            <div class="col-md-12">
                                <label for="" class="form-label">Xếp hạng đánh giá</label>
                                <select name="rating" class="form-select">
                                    <option value="{{ $commentById->rating }}">{{ $commentById->rating }}⭐</option>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>
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
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        <div class="col-md-12">
                                <label for="categoryInput" class="form-label">Tên danh mục</label>
                                <input type="text" class="form-control" value="{{ $commentById->status }}"
                        name="categoriesName" id="categoryInput" placeholder="Nhập tên danh mục...">
                    </div>
                    <div class="col-12 mt-3">
                        <div class="text-start">
                            <button type="button" id="btnUpdateCategories" name="insertCategory"
                                class="btn btn-primary">Cập nhật danh
                                mục</button>
                            <a href="/admin/categories/" class="btn btn-outline-warning">Quay lại</a>
                        </div>
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
            let btnUpdateCategories = document.querySelector('#btnUpdateCategories');

            btnUpdateCategories.addEventListener('click', function() {
                let categoryName = document.querySelector('#categoryInput');

                let data = {
                    name: categoryName.value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                };

                $.ajax({
                    url: '{{ route("categories.updateCategories", ["id" => $id]) }}',
type: 'POST',
dataType: 'json',
data: data,
success: function(response) {
if (response.messageUpdate) {
Swal.fire({
position: "top-end",
icon: "success",
title: `Cập nhật danh mục thành công`,
showConfirmButton: false,
timer: 2500
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
text: `${xhr.responseJSON.message}`,
showConfirmButton: false,
timer: 2500
});
}
});
});
});

</script>
@endsection