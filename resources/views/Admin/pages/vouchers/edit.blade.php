@extends('Admin.layouts.master')

@section('title')
    Cập nhật voucher
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Cập nhật voucher</h4>
                    </div>
                    <!-- end card header -->

                    <div class="card-body">
                        <form action="{{ route('vouchers.update', $voucher->id) }}" enctype="multipart/form-data"
                            method="post">
                            @csrf
                            @method('POST')
                            <div class="live-preview">
                                <div class="col-md-12 mb-3">
                                    <label for="categoryInput" class="form-label">Mã voucher <span
                                            class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('code', $voucher->code) }}"
                                        class="form-control code" name="code" id="code"
                                        placeholder="Nhập mã voucher...">
                                    @error('code')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="categoryInput" class="form-label">Tên voucher <span
                                            class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('name', $voucher->name) }}"
                                        class="form-control name" name="name" id="name"
                                        placeholder="Nhập tên voucher...">
                                    @error('name')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="categoryInput" class="form-label">Giá trị giảm <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">VND</span>
                                        <input type="number" value="{{ old('discount_value', $voucher->discount_value) }}"
                                            placeholder="VD: 100000,..." name="discount_value" id="discount_value"
                                            class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                    @error('discount_value')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3 discount_min_price-div"
                                    style="display: {{ old('discount_type', $voucher->discount_type) == 'condition' ? 'block' : 'none' }}">
                                    <label for="categoryInput" class="form-label">Giá trị đơn hàng tối thiểu</label>
                                    <div class="input-group">
                                        <span class="input-group-text">VND</span>
                                        <input type="number"
                                            value="{{ old('discount_min_price', $voucher->discount_min_price) }}"
                                            placeholder="VD: 100000,..." name="discount_min_price" id="discount_min_price"
                                            class="form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                    @error('discount_min_price')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="categoryInput" class="form-label">Loại giảm giá <span
                                            class="text-danger">*</span></label>
                                    <div class="form-check">
                                        <input type="radio" value="all"
                                            {{ old('discount_type', $voucher->discount_type) == 'all' ? 'checked' : '' }}
                                            class="form-check-input allDiscount" name="discount_type">
                                        <label class="form-check-label" for="validationFormCheck2">Áp dụng cho tất
                                            cả</label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input type="radio" value="condition"
                                            {{ old('discount_type', $voucher->discount_type) == 'condition' ? 'checked' : '' }}
                                            class="form-check-input condition" name="discount_type">
                                        <label class="form-check-label" for="validationFormCheck2">Điều kiện áp dụng</label>
                                    </div>
                                    @error('discount_type')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="categoryInput" class="form-label">Số lượt sử dụng</label>
                                    <input type="text" value="{{ old('total_uses', $voucher->total_uses) }}"
                                        class="form-control total_uses" name="total_uses" id="total_uses"
                                        placeholder="Nhập số lượt sử dụng...">
                                    @error('total_uses')
                                        <span class="text-danger mt-3">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="exampleInputdate" class="form-label">Thời gian bắt đầu</label>
                                            <input type="date" name="start_date"
                                                value="{{ old('start_date', date('Y-m-d', strtotime($voucher->start_date))) }}"
                                                class="form-control" id="exampleInputdate">
                                            @error('start_date')
                                                <span class="text-danger mt-3">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="exampleInputdate" class="form-label">Thời gian kết thúc</label>
                                            <input type="date" name="end_date"
                                                value="{{ old('end_date', date('Y-m-d', strtotime($voucher->end_date))) }}"
                                                class="form-control" id="exampleInputdate">
                                            @error('end_date')
                                                <span class="text-danger mt-3">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="text-start">
                                        <button type="submit" class="btn btn-primary insertCategory">Cập nhật
                                            voucher</button>
                                        <a href="{{ route('vouchers.index') }}" class="btn btn-outline-warning">Quay
                                            lại</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Hiển thị hoặc ẩn trường Giá trị đơn hàng tối thiểu theo lựa chọn ban đầu
            if ($('.condition').is(':checked')) {
                $('.discount_min_price-div').show();
            } else {
                $('.discount_min_price-div').hide();
            }

            // Bật sự kiện change để hiển thị hoặc ẩn trường khi chọn loại giảm giá
            $('.allDiscount').on('change', function() {
                $('.discount_min_price-div').hide();
                $('#discount_min_price').val(''); // Xóa giá trị ô điều kiện
            });

            $('.condition').on('change', function() {
                $('.discount_min_price-div').show();
            });
        });
    </script>
@endsection
