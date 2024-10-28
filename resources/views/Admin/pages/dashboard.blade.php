@extends('Admin.layouts.master')

@section('title')
    Bảng điều khiển
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
                                                            data-target="{{ !empty($data['order_pending']) ? $data['order_pending'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            data-target="{{ !empty($data['order_confirmed']) ? $data['order_confirmed'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            data-target="{{ !empty($data['order_shipping']) ? $data['order_shipping'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            class="counter-value"
                                                            data-target="{{ !empty($data['order_delivering']) ? $data['order_delivering'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            class="counter-value"
                                                            data-target="{{ !empty($data['order_completed']) ? $data['order_completed'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            class="counter-value"
                                                            data-target="{{ !empty($data['order_failed']) ? $data['order_failed'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                            class="counter-value"
                                                            data-target="{{ !empty($data['order_cancelled']) ? $data['order_cancelled'] : 0 }}">0</span>
                                                        Đơn hàng </h4>
                                                    <a href="{{ route('orders.index') }}"
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
                                                <div class="mt-3">
                                                    <h4>Doanh thu: <span class="counter-value"
                                                            data-target="{{ !empty($totalRevenueThisMonth) ? $totalRevenueThisMonth : 0 }}">0</span> VNĐ</h4>
                                                    <p>Số đơn: {{ !empty($totalOrders) ? $totalOrders : 0 }} đơn</p>
                                                </div>
                                            </div>
                                            <form action="{{ route('orders.index') }}" method="post">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <div class="row">
                                                        <div class="col">
                                                            <select class="form-select" name="filter" id="">
                                                                <option value="month">Theo tháng</option>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select class="form-select" name="month" id="">
                                                                <option value="">-- Chọn --</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
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
                });
            }


            $('#btnFilter').on('click', function() {
                const month = $('select[name="month"]').val();

                $.ajax({
                    url: "{{ route('orders.getRevenueAndProfitData') }}",
                    method: 'GET',
                    data: {
                        month: month
                    },
                    dataType: 'json',
                    success: function(data) {
                        createBarChart(data);
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi tải dữ liệu biểu đồ:', error);
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
