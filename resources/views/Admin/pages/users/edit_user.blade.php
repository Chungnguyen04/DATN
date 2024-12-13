@extends('admin.layouts.master')

@section('title')
    Cập nhật người dùng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Cập nhật người dùng</h4>
                    </div><!-- end card header -->

                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="live-preview">
                                <!-- Tên Người Dùng -->
                                <div class="col-md-6 mt-3">
                                    <label for="userName" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" name="name" id="userName" disabled
                                        placeholder="Nhập tên người dùng..." value="{{ $user->name }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mt-3">
                                    <label for="userEmail" class="form-label">Tài khoản</label>
                                    <input type="email" class="form-control" name="email" id="userEmail" disabled
                                        placeholder="Nhập email..." value="{{ $user->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Số Điện Thoại -->
                                <div class="col-md-6 mt-3">
                                    <label for="userPhone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" id="userPhone" disabled
                                        placeholder="Nhập số điện thoại..." value="{{ $user->phone }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Địa Chỉ -->
                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control" name="address" id="userAddress" disabled
                                        placeholder="Nhập địa chỉ..." value="{{ $user->address }}">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Tỉnh / Thành phố</label>
                                    <select disabled name="type" data-url="{{ route('api.districts') }}" id="tinh"
                                        name="province_id" class="form-select">
                                        <option value="">-- Chọn tỉnh / thành phố --</option>
                                        @if (!empty($data['provinces']))
                                            @foreach ($data['provinces'] as $province)
                                                <option {{ $province->id == $user->province_id ? 'selected' : '' }} value="{{ $province->id }}">{{ $province->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Quận / Huyện</label>
                                    <select disabled name="type" data-url="{{ route('api.wards') }}" id="quan"
                                        name="district_id" class="form-select">
                                        @if (!empty($data['districts']))
                                            @foreach ($data['districts'] as $district)
                                                <option {{ $district->id == $user->district_id ? 'selected' : '' }} value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="userAddress" class="form-label">Phường / Xã</label>
                                    <select name="type" name="ward_id" id="phuong" class="form-select" disabled>
                                        <option value="">-- Chọn phường / xã --</option>
                                        @if (!empty($data['wards']))
                                            @foreach ($data['wards'] as $ward)
                                                <option {{ $ward->id == $user->ward_id ? 'selected' : '' }} value="{{ $ward->id }}">{{ $ward->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Vai Trò -->
                                <div class="col-md-6 mt-3">
                                    <label for="userType" class="form-label">Vai trò</label>
                                    <select name="type" id="userType" class="form-select">
                                        <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>admin
                                        </option>
                                        <option value="member" {{ $user->type == 'member' ? 'selected' : '' }}>member
                                        </option>                                    
                                    </select>
                                </div>

                                <div class="col-12 mt-4">
                                    <div class="text-start">
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Quay lại</a>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
  
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
                method: 'GET',
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
                method: 'GET', 
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