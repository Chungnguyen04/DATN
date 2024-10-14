@extends('Admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <form action="" method="get">
                        <div class="row mb-2">
                            <div class="col">
                                <div>
                                    <label for="" class="label">Mã đơn / Tên</label>
                                    <input class="search form-control" value="{{ request('information') }}" name="information" placeholder="Mã đơn / Tên...">
                                </div>
                            </div>
                            <div class="col">
                                <div>
                                    <label for="" class="label">Trạng thái đơn hàng</label>
                                    <select name="status" class="form-select">
                                        <option value="" selected>--Chọn--</option>
                                        <option value="pending" @selected(request('status') == 'pending')>Chờ xác nhận</option>
                                        <option value="confirmed" @selected(request('status') == 'confirmed')>Đã xác nhận</option>
                                        <option value="shipping" @selected(request('status') == 'shipping')>Đang giao</option>
                                        <option value="delivering" @selected(request('status') == 'delivering')>Giao hàng thành công</option>
                                        <option value="failed" @selected(request('status') == 'failed')>Giao hàng thất bại</option>
                                        <option value="cancelled" @selected(request('status') == 'cancelled')>Đã huỷ</option>
                                        <option value="completed" @selected(request('status') == 'completed')>Hoàn thành / Đã nhận được hàng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="mt-4">
                                    <button class="btn btn-primary sort" type="submit">
                                        <i class="ri ri-filter-line"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Danh sách đơn hàng</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    @if(count($orders) > 0)
                                        <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                            <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 46px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="cardtableCheck">
                                                        <label class="form-check-label" for="cardtableCheck"></label>
                                                    </div>
                                                </th>
                                                <th scope="col">STT</th>
                                                <th scope="col">Mã đơn hàng</th>
                                                <th scope="col">Người đặt hàng</th>
                                                <th scope="col">Tổng đơn hàng</th>
                                                <th scope="col">Trạng thái đơn hàng</th>
                                                <th scope="col">Trạng thái thanh toán</th>
                                                <th scope="col">Ngày mua</th>
                                                <th scope="col" style="width: 150px;">Thao tác</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($orders))
                                                @foreach($orders as $key => $order)
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value=""
                                                                       id="cardtableCheck03">
                                                                <label class="form-check-label"
                                                                       for="cardtableCheck03"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $order->code }}</td>
                                                        <td>{{ !empty($order->user_id) ? $order->user_id : 'Khách vãng lai' }}</td>
                                                        <td>{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if(!empty($order->status))
                                                                @if($order->status == 'pending')
                                                                    <span class="badge bg-danger">Chờ xác nhận</span>
                                                                @elseif($order->status == 'confirmed')
                                                                    <span class="badge bg-success">Đã xác nhận</span>
                                                                @elseif($order->status == 'shipping')
                                                                    <span class="badge bg-primary">Đang giao</span>
                                                                @elseif($order->status == 'delivering')
                                                                    <span class="badge bg-success">Giao hàng thành công</span>
                                                                @elseif($order->status == 'failed')
                                                                    <span class="badge bg-danger">Giao hàng thất bại</span>
                                                                @elseif($order->status == 'cancelled')
                                                                    <span class="badge bg-danger">Đã huỷ</span>
                                                                @elseif($order->status == 'completed')
                                                                    <span class="badge bg-success">Hoàn thành / Đã nhận được hàng</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($order->payment_status))
                                                                @if($order->payment_status == 'unpaid')
                                                                    <span class="badge bg-danger">Chưa thanh toán</span>
                                                                @elseif($order->payment_status == 'paid')
                                                                    <span class="badge bg-success">Đã thanh toán</span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($order->created_at))
                                                                {{ date('d/m/Y H:i:s', strtotime($order->created_at)) }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a style="margin: 0 5px; cursor: pointer;"
                                                               data-bs-toggle="modal" class="link-primary" data-bs-target="#modalOrderDetail{{ $order->id }}">
                                                                <i class="ri-eye-line" style="font-size:18px;"></i>
                                                            </a>
                                                            <a style="margin: 0 5px; cursor: pointer;" data-bs-toggle="modal"
                                                               data-bs-target="#topmodal{{ $order->id }}" class="link-danger">
                                                                <i class="ri-delete-bin-5-line" style="font-size:18px;"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <div id="topmodal{{ $order->id }}" class="modal fade" tabindex="-1"
                                                         aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                               trigger="loop"
                                                                               colors="primary:#f7b84b,secondary:#405189"
                                                                               style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4">
                                                                        <h4 class="mb-3">Bạn muốn xóa đơn hàng này không?</h4>
                                                                        <p class="text-muted mb-4"> Bạn không thể hoàn tác lại thao tác này!</p>
                                                                        <div class="hstack gap-2 justify-content-center">
                                                                            <a href="javascript:void(0);"
                                                                               class="btn btn-link link-success fw-medium btnClose{{ $order->id }}"
                                                                               data-bs-dismiss="modal"><i
                                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                                Hủy</a>
                                                                            <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                        class="btn btn-success">Xóa</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="p-5">
                                                Không có đơn hàng nào
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div>{{ $orders->links('pagination::bootstrap-4') }}</div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div> <!-- end col -->
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.changeStatusOrder', function () {
                var url = $(this).data('url');
                var id = $(this).data('id');
                var status = $(this).data('status'); // Trạng thái hiện tại của đơn hàng
                var _token = $('meta[name="csrf-token"]').attr('content');
                var button = $(this);

                if (status == 'completed') {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: `Đơn hàng đã giao hàng!`,
                        text: 'Không thể thay đổi.',
                        showConfirmButton: true,
                    });

                    return;
                }

                // Hiển thị thông báo xác nhận
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: 'Bạn có muốn chuyển trạng thái đơn hàng không?',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kiểm tra trạng thái
                        if (status == 'cancelled') {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: `Đơn hàng đã bị hủy!`,
                                text: 'Không thể thay đổi.',
                                showConfirmButton: true,
                            });
                        } else {
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {
                                    id: id,
                                    status: status,
                                    _token: _token
                                },
                                success: function (response) {
                                    if (response.success) {
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });

                                        // Cập nhật trạng thái mới cho button
                                        var newStatus = response.status;
                                        button.data('status', newStatus); // Cập nhật data-status

                                        // Cập nhật trạng thái và class cho button
                                        button.removeClass(); // Xóa tất cả class trước đó
                                        button.addClass('btn changeStatusOrder'); // Thêm lại class mặc định

                                        if (newStatus == 'pending') {
                                            button.text('Chờ xác nhận');
                                            button.addClass('btn-danger');
                                        } else if (newStatus == 'shipping') {
                                            button.text('Đang vận chuyển');
                                            button.addClass('btn-warning');
                                        } else if (newStatus == 'delivering') {
                                            button.text('Đang giao hàng');
                                            button.addClass('btn-primary');
                                        } else if (newStatus == 'completed') {
                                            button.text('Đã giao hàng');
                                            button.addClass('btn-success');

                                            // Xử lý cập nhật trạng thái thanh toán thành 'Đã thanh toán'
                                            var paymentButton = $('.changePaymentStatusOrder[data-id="' + id + '"]');
                                            if (paymentButton.length) {
                                                paymentButton.removeClass();
                                                paymentButton.text('Đã thanh toán');
                                                paymentButton.addClass('btn btn-success changePaymentStatusOrder');
                                                paymentButton.data('payment-status', 'paid'); // Cập nhật data-payment-status nếu cần
                                            }
                                        }

                                        button.attr('data-status', newStatus); // Cập nhật lại data-status
                                    }
                                },
                                error: function (error) {
                                    console.log(error);
                                }
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.changePaymentStatusOrder', function () {
                var url = $(this).data('url');
                var id = $(this).data('id');
                var paymentStatus = $(this).data('status'); // Trạng thái thanh toán
                var button = $(this);

                // Tìm nút thay đổi trạng thái đơn hàng gần nhất
                var orderButton = button.closest('tr').find('.changeStatusOrder');

                // Kiểm tra nếu orderButton tồn tại
                if (orderButton.length) {
                    var orderStatus = orderButton.data('status'); // Trạng thái đơn hàng
                } else {
                    console.log('Không tìm thấy nút thay đổi trạng thái đơn hàng.');
                    return; // Dừng lại nếu không tìm thấy
                }

                // Kiểm tra trạng thái đơn hàng
                if (orderStatus === 'completed') {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: 'Đơn hàng đã được giao thành công!',
                        text: 'Không thể thay đổi trạng thái thanh toán.',
                        showConfirmButton: true,
                    });
                    return; // Dừng lại nếu đơn hàng đã hoàn thành
                }

                // Hiện thị thông báo xác nhận
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: ' Bạn muốn chuyển trạng thái thanh toán đơn hàng không?',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Thực hiện thay đổi trạng thái thanh toán
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                id: id,
                                payment_status: paymentStatus,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                console.log(response.payment_status)
                                if (response.success) {
                                    Swal.fire({
                                        position: "center",
                                        icon: "success",
                                        title: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    // Cập nhật trạng thái không cho button
                                    var newStatus = response.payment_status;
                                    button.data('status', newStatus); // Cập nhật data-status

                                    // Cập nhật trạng thái và class cho button
                                    button.removeClass(); // Xóa tất cả class trước đó
                                    button.addClass('btn changePaymentStatusOrder'); // Thêm lại class mặc định

                                    if (newStatus == 'unpaid') {
                                        button.text('Chưa thanh toán');
                                        button.addClass('btn-danger');
                                    } else if (newStatus == 'paid') {
                                        button.text('Đã thanh toán');
                                        button.addClass('btn-success');
                                    }

                                    button.attr('data-status', newStatus); // Cập nhật lại data-status
                                }
                            },
                            error: function (error) {
                                console.log(error);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
