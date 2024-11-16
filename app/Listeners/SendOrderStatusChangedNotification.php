<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusChangedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChanged $event): void
    {
        // thông báo về mail khi thay đổi trạng thái đơn hàng
        Mail::to($event->user->email)->send(new OrderConfirmation($event->order));
    }
}
