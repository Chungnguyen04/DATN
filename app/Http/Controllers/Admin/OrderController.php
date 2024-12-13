<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusChanged as EventsOrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatusHistory;
use App\Models\Variant;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with([
            'user',
            'province',
            'district',
            'ward',
            'orderDetails',
            'orderStatusHistories',
            'orderStatusHistories.user',
            'orderDetails.variant',
            'orderDetails.variant.weight',
        ]);

        if (!empty($request->input('information'))) {
            $information = $request->input('information');
            $orders = $orders->where(function ($query) use ($information) {
                $query->where('code', 'like', '%' . $information . '%')
                    ->orWhere('name', 'like', '%' . $information . '%')
                    ->orWhere('phone', 'like', '%' . $information . '%');
            });
        }

        if (!empty($request->input('status'))) {
            $orders = $orders->where('status', $request->input('status'));
        }

        $orders = $orders->orderBy('id', 'desc')
            ->paginate(5);

        if ($request->query('page') > 0) {
            $currentPage = $request->query('page', 1);
        }

        session([
            'page' => $currentPage ?? null,
        ]);
        $orders->appends(request()->query());

        return view('admin.pages.orders.index', compact('orders'));
    }

    public function updateOrderStatus(UpdateOrderRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Tìm đơn hàng
            $order = Order::with([
                'user',
                'province',
                'district',
                'ward',
                'voucher',
                'orderDetails',
                'orderStatusHistories',
                'orderStatusHistories.user',
                'orderDetails.variant',
                'orderDetails.variant.weight',
                'orderDetails.variant.product',
            ])->find($id);

            // Kiểm tra đơn hàng có tồn tại không
            if (!$order) {
                return redirect()->route('orders.index')->with('status_failed', 'Đơn hàng không tồn tại!');
            }

            // Xử lý hủy đơn hàng: trả lại số lượng sản phẩm
            if ($request->new_status == 'cancelled') {
                $orderDetails = OrderDetail::where('order_id', $order->id)->get();

                foreach ($orderDetails as $detail) {
                    $variant = Variant::find($detail->variant_id);

                    if ($variant) {
                        $variant->quantity += $detail->quantity;
                        $variant->save();
                    }
                }
            }
            // Lưu trạng thái cũ
            $oldStatus = $order->status;

            // Cập nhật trạng thái mới
            if ($request->new_status == 'completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'status' => $request->new_status,
                    'updated_at' => now(),
                ]);
            } else {
                $order->update([
                    'status' => $request->new_status,
                    'updated_at' => now(),
                ]);
            }

            // Ghi lại lịch sử thay đổi trạng thái
            OrderStatusHistory::create([
                'order_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $request->new_status,
                'changed_by' => auth()->user()->id ?? 0,
                'note' => $request->note,
            ]);

            // Lấy khách hàng liên quan đến đơn hàng
            $user = $order->user; // Quan hệ phải được định nghĩa trong model Order

            if (!$user || !$user->email) {
                return redirect()->route('orders.index')->with('status_failed', 'Người dùng không hợp lệ!');
            }

            EventsOrderStatusChanged::dispatch($order, $user);

            DB::commit();

            $currentPage = session('page', 1);

            $url = route('orders.index', ['page' => $currentPage]);

            return redirect($url)->with('status_succeed', 'Đơn hàng đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating order status', [
                'order_id' => $id,
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('status_failed', 'Đã xảy ra lỗi khi cập nhật!');
        }
    }

    // Xóa đơn hàng
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $order = Order::find($id);

            if (!$order) {
                return redirect()->route('orders.index')->with('status_failed', 'Đơn hàng không tồn tại!');
            }

            $order->delete();

            $order->orderDetails()->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('status_succeed', 'Đơn hàng đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return back()->with('status_failed', 'Đã xảy ra lỗi khi xóa!');
        }
    }
}
