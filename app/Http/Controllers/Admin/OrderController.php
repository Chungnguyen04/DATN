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

        return view('admin.pages.orders.index', compact('orders'));
    }

    public function updateOrderStatus(UpdateOrderRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Tìm đơn hàng
            $order = Order::find($id);

            // Kiểm tra đơn hàng có tồn tại không
            if (!$order) {
                Log::error('Order not found', ['order_id' => $id]);
                return redirect()->route('orders.index')->with('status_failed', 'Đơn hàng không tồn tại!');
            }

            Log::info('Updating order status', [
                'order_id' => $order->id,
                'current_status' => $order->status,
                'new_status' => $request->new_status,
            ]);
            // Xử lý hủy đơn hàng: trả lại số lượng sản phẩm
            if ($request->new_status == 'cancelled') {
                Log::info('Order is being cancelled', ['order_id' => $order->id]);
                $orderDetails = OrderDetail::where('order_id', $order->id)->get();

                foreach ($orderDetails as $detail) {
                    $variant = Variant::find($detail->variant_id);

                    if ($variant) {
                        Log::info('Updating variant quantity', [
                            'variant_id' => $variant->id,
                            'current_quantity' => $variant->quantity,
                            'return_quantity' => $detail->quantity,
                        ]);

                        $variant->quantity += $detail->quantity;
                        $variant->save();
                    } else {
                        Log::warning('Variant not found for order detail', [
                            'detail_id' => $detail->id,
                            'variant_id' => $detail->variant_id,
                        ]);
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
                ]);
            } else {
                $order->update([
                    'status' => $request->new_status,
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
                Log::error('User hoặc email của user không hợp lệ', [
                    'order_id' => $order->id,
                    'user_id' => $user->id ?? null,
                ]);
                return redirect()->route('orders.index')->with('status_failed', 'Người dùng không hợp lệ!');
            }

            Log::info('Dispatching OrderStatusChanged event', [
                'order_id' => $order->id,
                'user_email' => $user->email,
            ]);

            // Dispatch event với email của khách hàng
            EventsOrderStatusChanged::dispatch($order, $user);

            DB::commit();

            return redirect()->route('orders.index')->with('status_succeed', 'Đơn hàng đã được cập nhật thành công!');
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
