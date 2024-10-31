@extends('Admin.layouts.master')

@section('title')
    Danh sách voucher
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Danh sách voucher</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <a href="{{ route('vouchers.create') }}" class="btn btn-primary m-3">Thêm mới
                                        voucher</a>
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
                                                <th scope="col">Tên voucher</th>
                                                <th scope="col">Giá trị giảm</th>
                                                <th scope="col">Giá trị tối thiểu</th>
                                                <th scope="col">Điều kiện áp dụng</th>
                                                <th scope="col">Thời gian còn lại</th>
                                                <th scope="col">Số lượt sử dụng</th>
                                                <th scope="col" style="width: 150px;">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($vouchers))
                                                @foreach ($vouchers as $key => $voucher)
                                                    @php
                                                        $endDate = \Carbon\Carbon::parse($voucher->end_date);
                                                        $now = \Carbon\Carbon::now();
                                                        $timeLeft = $endDate->diffForHumans($now, true);
                                                    @endphp
                                                    <tr data-id-tr="{{ $voucher->id }}"
                                                        data-end-date="{{ $voucher->end_date }}">
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="cardtableCheck03">
                                                                <label class="form-check-label"
                                                                    for="cardtableCheck03"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $voucher->name }}</td>
                                                        <td>{{ number_format($voucher->discount_value, 0, ',', '.') }} VND
                                                        </td>
                                                        <td>{{ number_format($voucher->discount_min_price, 0, ',', '.') }}
                                                            VND</td>
                                                        <td>{{ $voucher->discount_type == 'all' ? 'Áp dụng cho tất cả' : 'Điều kiện giảm giá' }}
                                                        </td>
                                                        <td class="time-left" id="time-left-{{ $voucher->id }}"></td>
                                                        <td>{{ $voucher->total_uses }} lần</td>
                                                        <td>
                                                            <a style="margin: 0 5px; cursor: pointer;"
                                                                href="{{ route('vouchers.edit', $voucher->id) }}"
                                                                class="link-primary"><i class="ri-settings-4-line"
                                                                    style="font-size:18px;"></i></a>
                                                            <a style="margin: 0 5px; cursor: pointer;"
                                                                class="link-danger"><i class="ri-delete-bin-5-line"
                                                                    style="font-size:18px;" data-bs-toggle="modal"
                                                                    data-bs-target="#topmodal{{ $voucher->id }}"></i></a>
                                                        </td>
                                                    </tr>
                                                    <div id="topmodal{{ $voucher->id }}" class="modal fade" tabindex="-1"
                                                        aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                        trigger="loop"
                                                                        colors="primary:#f7b84b,secondary:#405189"
                                                                        style="width:130px;height:130px"></lord-icon>
                                                                    <div class="mt-4">
                                                                        <h4 class="mb-3">Bạn muốn xóa trọng lượng này?
                                                                        </h4>
                                                                        <p class="text-muted mb-4"> Bạn không thể hoàn tác
                                                                            dữ liệu này!</p>
                                                                        <div class="hstack gap-2 justify-content-center">
                                                                            <a href="javascript:void(0);"
                                                                                class="btn btn-link link-success fw-medium btnClose{{ $voucher->id }}"
                                                                                data-bs-dismiss="modal"><i
                                                                                    class="ri-close-line me-1 align-middle"></i>
                                                                                Hủy</a>
                                                                            <form
                                                                                action="{{ route('vouchers.delete', $voucher->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-success btnDel">Xóa</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                    <div class="d-flex justify-content-center align-items-center">
                        <div>{{ $vouchers->links('pagination::bootstrap-4') }}</div>
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div> <!-- end col -->
@endsection

@section('script')
    <script>
        function updateCountdown() {
            $("tr[data-id-tr]").each(function() {
                const endDate = new Date($(this).data("end-date"));
                const now = new Date();
                const timeDiff = endDate - now;

                if (timeDiff > 0) {
                    const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

                    let displayText = "";
                    if (days >= 1) {
                        displayText += `${days} ngày `;
                    }
                    displayText += `${hours} giờ ${minutes} phút ${seconds} giây`;

                    $(this).find(".time-left").text(displayText);
                } else {
                    $(this).find(".time-left").text("Voucher đã hết hạn");
                }
            });
        }

        setInterval(updateCountdown, 1000);
    </script>
@endsection
