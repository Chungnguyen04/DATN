<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->order->status == 'pending') {
            $statusText = 'đang được chờ xác nhận';
        } elseif ($this->order->status == 'confirmed') {
            $statusText = 'đã xác nhận';
        } elseif ($this->order->status == 'shipping') {
            $statusText = 'đang được giao đến bạn';
        } elseif ($this->order->status == 'delivering') {
            $statusText = 'đã được giao hàng thành công';
        } elseif ($this->order->status == 'failed') {
            $statusText = 'giao hàng thất bại';
        } elseif ($this->order->status == 'cancelled') {
            $statusText = 'đã hủy';
        } elseif ($this->order->status == 'completed') {
            $statusText = 'đã hoàn thành';
        }

        return $this->view('emails.order_confirmation')
            ->subject('Đơn hàng #' . $this->order->code . ' của bạn ' . $statusText)
            ->with([
                'order' => $this->order,
                'status' => $this->order->status,
            ])->attach(public_path('images/logo-mail.jpg'), [
                    'as' => 'logo-mail.jpg',
                    'mime' => 'image/png',
                ]);
    }

    public function envelope(): Envelope
    {
        if ($this->order->status == 'pending') {
            $statusText = 'đang được chờ xác nhận';
        } elseif ($this->order->status == 'confirmed') {
            $statusText = 'đã xác nhận';
        } elseif ($this->order->status == 'shipping') {
            $statusText = 'đang được giao đến bạn';
        } elseif ($this->order->status == 'delivering') {
            $statusText = 'đã được giao hàng thành công';
        } elseif ($this->order->status == 'failed') {
            $statusText = 'giao hàng thất bại';
        } elseif ($this->order->status == 'cancelled') {
            $statusText = 'đã hủy';
        } elseif ($this->order->status == 'completed') {
            $statusText = 'đã hoàn thành';
        }

        return new Envelope(
            subject: 'Đơn hàng #' . $this->order->code . ' của bạn ' . $statusText,
        );
    }
}
