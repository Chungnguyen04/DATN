@extends('admin.layouts.master')

@section('title')
    Bảng thống kê
@endsection

@section('css')
    <style>
        <style>
        /* CSS for horizontal layout */

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            gap: 20px;
            /* Khoảng cách giữa hai phần */
            width: 100%;
            max-width: 100%;
            /* Giới hạn chiều rộng cho cả container */
        }

        .top-products,
        .top {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            /* Để cả hai phần chiếm đều nhau */
        }

        .top-products h3,
        .top h3 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 15px;
            color: #333;
            text-align: center;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .product-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .product-item {
            display: flex;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 10px;
            background-color: #fafafa;
            transition: box-shadow 0.3s ease;
        }

        .product-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-image-placeholder {
            width: 50px;
            height: 50px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
            color: #666;
            border-radius: 5px;
            font-size: 14px;
        }

        .product-details {
            flex-grow: 1;
        }

        .product-name {
            margin: 0;
            font-weight: bold;
            color: #333;
        }

        .product-code {
            margin: 2px 0 0;
            font-size: 12px;
            color: #888;
        }

        .product-price {
            font-weight: bold;
            color: #4CAF50;
            /* Màu xanh cho giá */
        }
    </style>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="h-100">
                        <div class="row">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Thống Kê Đơn Hàng</h4>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Chờ
                                                        xác nhận</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value"
                                                            data-target="{{ !empty($totalPendingOrders) ? $totalPendingOrders : 0 }}">{{ $totalPendingOrders }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=pending"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                        <i class="bx bx-popsicle text-danger"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Đã xác
                                                        nhận</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value"
                                                            data-target="{{ !empty($daxacnhan) ? $daxacnhan : 0 }}">{{ $daxacnhan }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=confirmed"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bxs-been-here text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Đang
                                                        giao</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value"
                                                            data-target="{{ !empty($danggiao) ? $danggiao : 0 }}">{{ $danggiao }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=shipping"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                        <i class="bx bxs-truck text-primary"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <form id="form-filter-order" method="post">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <input type="text" value="Thống kê theo tháng" readonly class="form-control">
                                                        </div>
            
                                                        <div class="col">
                                                            <div class="d-flex align-items-center">
                                                                <select id="monthSelectOrder" class="form-select w-75"
                                                                    style="margin-right: 10px;width: 133px !important;" name="month">
                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                        <option {{ $i == \Carbon\Carbon::now()->month ? 'selected' : '' }} value="{{ $i }}">Tháng
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                                <select id="yearSelectOrder" style="width: 133px !important;" class="form-select w-75"
                                                                    name="yearMonth">
                                                                    @for ($i = \Carbon\Carbon::now()->year; $i >= 2000; $i--)
                                                                        <option {{ $i == \Carbon\Carbon::now()->year ? 'selected' : '' }} value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: 10px">
                                                        <div class="col text-end">
                                                            <button data-url="{{ route('dashboards.filterMonthAndYear') }}" type="button" class="btn btn-primary"
                                                                id="btnFilterOrderStatus">Lọc</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Giao
                                                        thành công</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-value="giaothanhcong"
                                                            data-target="{{ !empty($giaothanhcong) ? $giaothanhcong : 0 }}">{{ $giaothanhcong }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=delivering"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bxs-check-circle text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Hoàn
                                                        thành / Đã nhận hàng</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-value="hoanthanh"
                                                            data-target="{{ !empty($totalCompletedOrders) ? $totalCompletedOrders : 0 }}">{{ $totalCompletedOrders }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=completed"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bxs-check-circle text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Giao
                                                        thất bại</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-value="giaothatbai"
                                                            data-target="{{ !empty($giaothatbai) ? $giaothatbai : 0 }}">{{ $giaothatbai }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=failed"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                        <i class="bx bxs-message-square-x text-danger"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-3 col-md-6">
                                    <!-- card -->
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Hủy
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span
                                                            class="counter-value" data-value="giaohuy"
                                                            data-target="{{ !empty($giaohuy) ? $giaohuy : 0 }}">{{ $giaohuy }}</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}?status=cancelled"
                                                        class="text-decoration-underline">Xem </a>
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                        <i class="bx bxs-message-alt-x text-danger"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->
                            </div>
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 class="card-title mb-0">Thống Kê Doanh Thu</h4>
                                                <!-- <div class="mt-3">
                                                    <h4>Doanh thu: <span class="counter-value"
                                                            data-target="{{ !empty($totalRevenueThisMonth) ? $totalRevenueThisMonth : 0 }}">0</span>
                                                        VNĐ</h4>
                                                    <p>Số đơn: {{ !empty($totalOrders) ? $totalOrders : 0 }} đơn</p>
                                                </div> -->
                                            </div>
                                            <form action="{{ route('orders.index') }}" method="post">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <div class="row">
                                                        <div class="col">
                                                            <select class="form-select" name="filter" id="filter">
                                                                <option value="">-- Chọn bộ lọc --</option>
                                                                <option value="day">Thống kê ngày</option>
                                                                <option value="month" selected>Thống kê tháng</option>
                                                                <option value="year">Thống kê năm</option>
                                                                <option value="range">Thống kê khoảng thời gian
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <!-- Lọc theo ngày cụ thể -->
                                                        <div class="col" id="dayFilter" style="display: none;">
                                                            <input type="date" id="dateFilter" name="date"
                                                                class="form-control">
                                                        </div>

                                                        <div class="col" id="monthFilter" style="display: none;">
                                                            <div class="d-flex align-items-center">
                                                                <select id="monthSelect" class="form-select"
                                                                    style="margin-right: 10px;width: 133px !important;" name="month">
                                                                    @for ($i = 1; $i <= 12; $i++)
                                                                        <option {{ $i == \Carbon\Carbon::now()->month ? 'selected' : '' }} value="{{ $i }}">Tháng
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                                <select id="yearSelect" class="form-select"
                                                                    name="yearMonth">
                                                                    @for ($i = \Carbon\Carbon::now()->year; $i >= 2000; $i--)
                                                                        <option {{ $i == \Carbon\Carbon::now()->year ? 'selected' : '' }} value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Lọc theo năm -->
                                                        <div class="col" id="yearFilter" style="display: none;">
                                                            <select id="yearSelect2" class="form-select"
                                                                name="year_filter">
                                                                <option value="">-- Chọn Năm --</option>
                                                            </select>
                                                        </div>

                                                        <!-- Lọc theo khoảng thời gian -->
                                                        <div class="col" id="rangeFilter" style="display: none;">
                                                            <input type="date" name="start_date" class="form-control"
                                                                id="start_date">
                                                        </div>

                                                        <div class="col" id="rangeFilterEnd" style="display: none;">
                                                            <input type="date" name="end_date" class="form-control"
                                                                id="end_date">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-left: 10px">
                                                        <div class="col text-end">
                                                            <button type="button" class="btn btn-primary"
                                                                id="btnFilter">Lọc</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="bar" class="chartjs-chart"
                                            data-colors='["--vz-success-rgb, 0.8", "--vz-success-rgb, 0.9"]'></canvas>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="container">
                                <div class="top-products">
                                    <h3>Top 5 Sản Phẩm Doanh Thu Cao Nhất</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên</th>
                                                <th>Ảnh</th>
                                                <th>Doanh Thu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topRevenueProducts as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                    <img src="{{ url($product->image) }}" alt="" style="width: 50px; height: 50px;">
                                                    </td>
                                                    <td>{{ number_format($product->total_revenue, 0, '.', ',') }} VND</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="top-products">
                                    <h3>Top 5 Sản Phẩm Bán Chạy Nhất</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên</th>
                                                <th>Ảnh</th>
                                                <th>Số Lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topSellingProducts as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                    <img src="{{ url($product->image) }}" alt="" style="width: 50px; height: 50px;">
                                                    </td>
                                                    <td>{{ ($product->total_sold ?? 0) }} Sản phẩm</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="top-products">
                                    <h3>Top 5 Sản Phẩm Lợi Nhuận Cao Nhất</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tên</th>
                                                <th>Ảnh</th>
                                                <th>Lợi Nhuận</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topProfitProducts as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                    <img src="{{ url($product->image) }}" alt="" style="width: 50px; height: 50px;">
                                                    </td>
                                                    <td>{{ number_format($product->total_profit, 0, '.', ',') }} VND</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- end row-->
                    </div> <!-- end .h-100-->
                </div> <!-- end col -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#btnFilterOrderStatus').on('click', function (e) {
                e.preventDefault();

                const url = $(this).data('url');
                const month = $('#monthSelectOrder').val();
                const year = $('#yearSelectOrder').val();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        month: month,
                        year: year
                    },
                    success: function (response) {
                        $('.counter-value[data-value]').each(function () {
                            const target = $(this).data('value');
                            if (response[target] !== undefined) {
                                $(this).text(response[target]);
                            }
                        });
                    },
                    error: function (xhr) {
                        alert('Có lỗi xảy ra! Vui lòng thử lại.');
                    }
                });
            });
            
            var currentMonth = new Date().getMonth() + 1; // Tháng trong JavaScript tính từ 0-11 nên cần +1
            var currentYear = new Date().getFullYear();

            var startYear = 2000;

            // Thêm các năm từ 2000 đến năm hiện tại vào select với id="yearSelect"
            for (var year = currentYear; year >= startYear; year--) {
                $('#yearSelect2').append('<option value="' + year + '">' + year + '</option>');
            }

            // Thiết lập tháng hiện tại là selected trong #monthSelect
            $('#monthSelect').val(currentMonth);

            // Thiết lập năm hiện tại là selected trong #yearSelect
            $('#yearSelect').val(currentYear);

            // Hiển thị hoặc ẩn các bộ lọc khác nhau khi thay đổi `#filter`
            $('#filter').on('change', function() {
                var filter = $(this).val(); // Lấy giá trị của select filter

                // Ẩn tất cả các bộ lọc
                $('#dayFilter').hide();
                $('#monthFilter').hide();
                $('#yearFilter').hide();
                $('#rangeFilter').hide();
                $('#rangeFilterEnd').hide();

                // Hiển thị bộ lọc tương ứng dựa trên giá trị đã chọn
                if (filter === 'day') {
                    $('#dayFilter').show(); // Hiển thị bộ lọc theo ngày
                } else if (filter === 'month') {
                    $('#monthFilter').show(); // Hiển thị bộ lọc theo tháng
                } else if (filter === 'year') {
                    $('#yearFilter').show(); // Hiển thị bộ lọc theo năm
                } else if (filter === 'range') {
                    $('#rangeFilter').show(); // Hiển thị bộ lọc theo khoảng thời gian
                    $('#rangeFilterEnd').show(); // Hiển thị bộ lọc kết thúc
                }
            });

            $('#monthFilter').show();

            let barChart; // Declare a variable to hold the chart instance

            function createBarChart(data) {
                const isbarchart = document.getElementById("bar");
                const barChartColor = getChartColorsArray("bar");

                // Destroy the existing chart instance if it exists
                if (barChart) {
                    barChart.destroy();
                }

                // Create a new chart instance
                barChart = new Chart(isbarchart, {
                    type: "bar",
                    data: {
                        labels: data.labels, // Gán nhãn ngày
                        datasets: [{
                                label: "Doanh thu",
                                backgroundColor: barChartColor[0],
                                borderColor: barChartColor[0],
                                borderWidth: 1,
                                hoverBackgroundColor: barChartColor[1],
                                hoverBorderColor: barChartColor[1],
                                data: data.revenue, // Gán dữ liệu doanh thu
                            },
                            {
                                label: "Lợi nhuận",
                                backgroundColor: "rgba(54, 162, 235, 0.8)", // Màu cho cột Lợi nhuận
                                borderColor: "rgba(54, 162, 235, 1)",
                                borderWidth: 1,
                                hoverBackgroundColor: "rgba(54, 162, 235, 0.9)",
                                hoverBorderColor: "rgba(54, 162, 235, 1)",
                                data: data.profit // Gán dữ liệu lợi nhuận
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                ticks: {
                                    font: {
                                        family: "Poppins"
                                    }
                                }
                            },
                            y: {
                                ticks: {
                                    font: {
                                        family: "Poppins"
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        family: "Poppins"
                                    }
                                }
                            },
                            animations: {
                                tension: {
                                    duration: 1000, // Thời gian hiệu ứng (ms)
                                    easing: 'easeOutBounce', // Kiểu easing cho hiệu ứng
                                    from: 1,
                                    to: 0,
                                    loop: true // Nếu muốn hiệu ứng lặp lại
                                },
                                // Hiệu ứng cho cột
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        animation: {
                                            duration: 1000, // Thời gian hiệu ứng
                                            easing: 'easeOutElastic', // Kiểu easing cho hiệu ứng
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            }

            $('#btnFilter').on('click', function() {
                const filter = $('select[name="filter"]').val();
                const date = $('#dateFilter').val();
                const year = $('#yearSelect2').val(); // Đổi từ yearSelect sang yearSelect2
                const yearMonth = $('#yearSelect').val(); // Đổi từ yearSelect sang yearSelect2
                const month = $('#monthSelect').val();
                const startDate = $('#start_date').val();
                const endDate = $('#end_date').val();

                // Gửi yêu cầu AJAX đến server
                $.ajax({
                    url: "{{ route('orders.getRevenueAndProfitData') }}",
                    method: 'GET',
                    data: {
                        filter: filter,
                        date: date,
                        year: year,
                        yearMonth: yearMonth,
                        month: month,
                        start_date: startDate,
                        end_date: endDate
                    },
                    dataType: 'json',
                    success: function(data) {
                        createBarChart(data); // Call the function to create the chart
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: xhr.responseJSON.error,
                            showConfirmButton: true,
                        })
                    }
                });
            });

            // Initial chart loading
            $.ajax({
                url: "{{ route('orders.getRevenueAndProfitData') }}",
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    createBarChart(data); // Call the function to create the chart
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi tải dữ liệu biểu đồ:', error);
                }
            });
        });
    </script>
@endsection
