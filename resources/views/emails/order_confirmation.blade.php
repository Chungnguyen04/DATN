<!DOCTYPE html>
<html>

<head>
    <title>Đơn hàng #{{ $order->code }} @if ($order->status == 'pending')
            đang được chờ xác nhận
        @elseif($order->status == 'confirmed')
            đã xác nhận
        @elseif($order->status == 'shipping')
            đang được giao đến bạn
        @elseif($order->status == 'delivering')
            đã được giao hàng thành công
        @elseif($order->status == 'failed')
            giao hàng thất bại
        @elseif($order->status == 'cancelled')
            đã hủy
        @elseif($order->status == 'completed')
            đã hoàn thành
        @else
            Không xác định
        @endif
    </title>
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333333;
        }

        .custom-container {
            display: flex !important;
            background-color: #ebebeb;
            height: 100%;
        }

        .email-container {
            max-width: 700px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 40px 3px #ccc;
        }

        .email-header {
            text-align: center;
        }

        .email-header img {
            max-width: 110px;
            margin-bottom: 15px;
        }

        .email-header h1 {
            color: #000000;
            font-size: 28px;
            margin: 0;
        }

        .box-email-forgotpassword {
            text-align: center !important;
        }

        .button_access {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #ffffff !important;
            background-color: #964187;
            text-decoration: none;
            border-radius: 5px;
        }

        .thankyou-footer {
            text-align: center !important;
        }
    </style>
</head>

<body>
    <div class="custom-container">
        <div style="border-collapse:collapse;padding:0;margin:0 auto;width:800px; margin-top: 80px !important;">
            <div class="email-container">
                <div class="email-header">
                    <img src="{{ $message->embed(public_path('images/logo-mail.jpg')) }}" alt="Logo của Nền tảng" />
                    <h1>Xin chào, {{ $order->user->name }}.</h1>
                </div>
                <div class="email-body">
                    <p>Đơn hàng <span style="color: orange">#{{ $order->code }}</span> của bạn @if ($order->status == 'pending')
                        đang được chờ xác nhận
                    @elseif($order->status == 'confirmed')
                        đã xác nhận
                    @elseif($order->status == 'shipping')
                        đang được giao đến bạn
                    @elseif($order->status == 'delivering')
                        đã được giao hàng thành công
                    @elseif($order->status == 'failed')
                        giao hàng thất bại
                    @elseif($order->status == 'cancelled')
                        đã hủy
                    @elseif($order->status == 'completed')
                        đã hoàn thành
                    @else
                        Không xác định
                    @endif
                        ngày {{ $order->updated_at }}.</p>
                    @if ($order->status == 'delivering')
                        <p>
                            Vui lòng đăng nhập Gemstone để xác nhận bạn đã nhận hàng
                        </p>
                    @endif
                    <div style="width:100%;height:1px;display:block" align="center">
                        <div style="width:100%;max-width:800px;height:1px;border-top:1px solid #e0e0e0"></div>
                    </div>
                    <div>
                        <table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0"
                            id="m_1447188810951310195backgroundTable">
                            <tbody>
                                <tr>
                                    <td>
                                        <table width="600" cellpadding="0" cellspacing="0" border="0"
                                            align="center">
                                            <tbody>
                                                @if(!empty($order->orderDetails))
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach($order->orderDetails as $index => $orderDetail)
                                                        @php
                                                            $total += $orderDetail->price * $orderDetail->quantity;
                                                        @endphp
                                                        <tr>
                                                            <td width="100%">
                                                                <table bgcolor="#ffffff" width="600" cellpadding="0"
                                                                    cellspacing="0" border="0" align="center">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td height="10"
                                                                                style="font-size:1px;line-height:1px">&nbsp;
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                <table width="560" align="center"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table width="560"
                                                                                                    align="center"
                                                                                                    border="0"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="560"
                                                                                                                height="140"
                                                                                                                align="left">
                                                                                                                <a>
                                                                                                                    <img src="{{ $message->embed(public_path($orderDetail->variant->product->image)) }}"
                                                                                                                        alt="{{ $orderDetail->variant->product->name }}"
                                                                                                                        border="0"
                                                                                                                        width="140"
                                                                                                                        height="140"
                                                                                                                        style="display:block;border:none;outline:none;text-decoration:none"
                                                                                                                        class="CToWUd"
                                                                                                                        data-bit="iit">
                                                                                                                </a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <table align="left"
                                                                                                    border="0"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td width="100%"
                                                                                                                height="10"
                                                                                                                style="font-size:1px;line-height:1px">
                                                                                                                &nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <table width="560"
                                                                                                    align="center"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    border="0"
                                                                                                    style="table-layout:fixed">
                                                                                                    <tbody>
                                                                                                        <tr>
                                                                                                            <td colspan="2"
                                                                                                                width=""
                                                                                                                height="20"
                                                                                                                style="font-size:1px;line-height:1px">
                                                                                                                &nbsp;</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td colspan="2"
                                                                                                                style="font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;text-align:left">
                                                                                                                {{ $index + 1 }}.
                                                                                                                {{ $orderDetail->variant->product->name }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">
                                                                                                                Trọng lượng: </td>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">{{ !empty($orderDetail->variant->weight->weight) ? $orderDetail->variant->weight->weight : '' }} {{ !empty($orderDetail->variant->weight->unit) ? $orderDetail->variant->weight->unit : '' }}
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">
                                                                                                                Giá: </td>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">
                                                                                                                {{ !empty($orderDetail->price) ? number_format($orderDetail->price, 0, '', ',') : '' }} VND</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">
                                                                                                                Số lượng: </td>
                                                                                                            <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                                width="49%">
                                                                                                                {{ !empty($orderDetail->quantity) ? $orderDetail->quantity : '' }}</td>
                                                                                                        </tr>
                                                                                                        <tr>
                                                                                                            <td width="100%"
                                                                                                                height="10"
                                                                                                                style="font-size:1px;line-height:1px">
                                                                                                                &nbsp;</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="100%" height="1" bgcolor="#ffffff"
                                                                                style="font-size:1px;line-height:1px">&nbsp;
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div style="width:100%;height:1px;display:block" align="center">
                            <div style="width:100%;max-width:600px;height:1px;border-top:1px solid #e0e0e0"></div>
                        </div>

                        <table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0"
                            id="m_1447188810951310195backgroundTable">
                            <tbody>
                                <tr>
                                    <td>
                                        <table width="600" cellpadding="0" cellspacing="0" border="0"
                                            align="center">
                                            <tbody>
                                                <tr>
                                                    <td width="100%">
                                                        <table bgcolor="#ffffff" width="600" cellpadding="0"
                                                            cellspacing="0" border="0" align="center">
                                                            <tbody>

                                                                <tr>
                                                                    <td height="10"
                                                                        style="font-size:1px;line-height:1px">&nbsp;
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td>
                                                                        <table width="560" align="center"
                                                                            cellpadding="0" cellspacing="0"
                                                                            border="0">
                                                                            <tbody>
                                                                                
                                                                                <tr>
                                                                                    <td>
                                                                                        <table width="560"
                                                                                            align="center"
                                                                                            cellpadding="0"
                                                                                            cellspacing="0"
                                                                                            border="0"
                                                                                            style="table-layout:fixed">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td colspan="2"
                                                                                                        style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px">
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        Tổng tiền:
                                                                                                    </td>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        {{ !empty($total) ? number_format($total, 0, '', ',') : '' }} VND
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        Voucher:
                                                                                                    </td>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        -{{ number_format($order->voucher->discount_value, 0, '', ',') . ' VND' }}
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        Phí vận chuyển:
                                                                                                    </td>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        {{ !empty($order->shipping_fee) ? number_format($order->shipping_fee, 0, '', ',') . ' VND' : '0 VND' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        Tổng thanh toán:
                                                                                                    </td>
                                                                                                    <td style="word-break:break-word;text-align:left;font-family:Helvetica,arial,sans-serif;font-size:13px;color:#000000;vertical-align:top"
                                                                                                        width="49%">
                                                                                                        {{ !empty($total) ? number_format($total - $order->discount_value + $order->shipping_fee, 0, '', ',') : '' }} VND
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td colspan="2"
                                                                                                        style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px">
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td colspan="2"
                                                                                                        style="text-align:left;font-family:Helvetica,arial,sans-serif;color:#1f1f1f;font-size:16px;font-weight:bold;height:10px">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="100%" height="1"
                                                                        bgcolor="#ffffff"
                                                                        style="font-size:1px;line-height:1px">&nbsp;
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="email-footer">
                    <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi tại <a
                            href="mailto:no-reply@bkm.vn">gemstonetrangsuc@gmail.com</a> hoặc qua điện thoại tại <a
                            href="tel:1900 6017">038 773 2069</a>.</p>
                </div>
            </div>
            <div class="thankyou-footer">
                <h5
                    style="font-family:Verdana,Arial;font-weight:normal;text-align:center;font-size:22px;line-height:32px;margin-bottom:75px;margin-top:30px">
                    Thank you, Gemstone!</h5>
            </div>
        </div>
    </div>
</body>

</html>
