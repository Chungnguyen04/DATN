@extends('admin.layouts.master')

@section('title')
    Thêm mới người dùng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thêm mới người dùng</h4>
                    </div>

                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="live-preview">

                                <div class="col-md-6 mt-3">
                                    <label for="userName" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                        id="userName" placeholder="Nhập tên người dùng...">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userEmail" class="form-label">Tài khoản</label>
                                    <input type="email" class="form-control" value="{{ old('email') }}" name="email"
                                        id="userEmail" placeholder="Nhập email...">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userPassword" class="form-label">Mật khẩu</label>
                                    <input type="text" class="form-control" name="password" id="userPassword"
                                        placeholder="Nhập mật khẩu...">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userPhone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" value="{{ old('phone') }}" name="phone"
                                        id="userPhone" placeholder="Nhập số điện thoại...">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" value="{{ old('address') }}" name="address"
                                        id="userAddress" placeholder="Nhập địa chỉ...">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Tỉnh / Thành phố</label>
                                    <select data-url="{{ route('api.districts') }}" id="tinh"
                                        name="province_id" class="form-select">
                                        <option value="">-- Chọn tỉnh / thành phố --</option>
                                        @if (!empty($data['provinces']))
                                            @foreach ($data['provinces'] as $province)
                                                <option value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Quận / Huyện</label>
                                    <select data-url="{{ route('api.wards') }}" id="quan"
                                        name="district_id" class="form-select">
                                        <option value="">-- Chọn quận / huyện --</option>
                                        @if (!empty($data['districts']))
                                            @foreach ($data['districts'] as $district)
                                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Phường / Xã</label>
                                    <select name="ward_id" id="phuong" class="form-select">
                                        <option value="">-- Chọn phường / xã --</option>
                                        @if (!empty($data['wards']))
                                            @foreach ($data['wards'] as $ward)
                                                <option value="{{ $ward->id }}">{{ $ward->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userType" class="form-label">Vai trò</label>
                                    <select name="type" id="userType" class="form-select">
                                        <option value="admin" @selected(old('type') == 'admin')>admin</option>
                                        <option value="member" @selected(old('type') == 'member')>member</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 mt-4 text-start">
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Quay lại</a>
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $("#tinh").change(function() {
            var province_id = $(this).val();
            var url = $(this).data('url');
            if (!province_id) {
                $("#quan").empty().append('<option value="">-- Chọn quận / huyện --</option>');
                $("#phuong").empty().append('<option value="">-- Chọn phường / xã --</option>');
                return;
            }
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    province_id: province_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var districts = response.districts; 
                    $("#quan").empty().append('<option value="">-- Chọn quận / huyện --</option>');
                    $("#phuong").empty().append('<option value="">-- Chọn phường / xã --</option>');
                    districts.map(function(district) {
                        var option = document.createElement('option');
                        option.value = district.id;
                        option.text = district.name;
                        $("#quan").append(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    console.log("Response: " + xhr.responseText);
                }
            });
        });

        $("#quan").change(function() {
            var district_id = $(this).val();
            var url = $(this).data('url');
            if (!district_id) {
                $("#phuong").empty().append('<option value="">-- Chọn phường / xã --</option>');
                return;
            }
            $.ajax({
                url: url,
                method: 'POST', 
                data: {
                    district_id: district_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var wards = response.wards;
                    $("#phuong").empty().append('<option value="">-- Chọn phường / xã --</option>');
                    wards.map(function(ward) {
                        var option = document.createElement('option');
                        option.value = ward.id;
                        option.text = ward.name;
                        $("#phuong").append(option);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);
                    console.log("Response: " + xhr.responseText);
                }
            });
        });
    });
</script>
@endsection