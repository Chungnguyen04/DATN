<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatusHistory;
use App\Models\Variant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
     // Danh sách đơn hàng theo người dùng
     public function getAllOrderByUser(Request $request, $userId)
     {
         try {
             $orders = Order::with([
                 'user',
                 'orderDetails',
                 'orderDetails.variant',
                 'orderDetails.variant.product',
                 'orderDetails.variant.weight',
             ]);
 
             if (!empty($request->code)) {
                 $orders = $orders->where('code', $request->code);
             }
 
             $orders = $orders->where('user_id', $userId)
                 ->orderBy('id', 'desc')
                 ->get();
 
             if ($orders->isEmpty()) {
                 return response()->json([
                     'status' => false,
                     'message' => 'Không có đơn hàng nào!'
                 ], Response::HTTP_NOT_FOUND);
             }
 
             return response()->json([
                 'status' => true,
                 'message' => 'Danh sách đơn hàng đã được lấy thành công.',
                 'data' => $orders
             ], Response::HTTP_OK);
         } catch (QueryException $e) {
             return response()->json([
                 'status' => false,
                 'message' => 'Đã xảy ra lỗi với cơ sở dữ liệu.',
                 'errors' => [$e->getMessage()],
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         } catch (ModelNotFoundException $e) {
             return response()->json([
                 'status' => false,
                 'message' => 'Lỗi models không tạo.',
                 'errors' => [$e->getMessage()],
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         } catch (\Exception $e) {
             // Lỗi hệ thống
             return response()->json([
                 'status' => false,
                 'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu',
                 'errors' => [$e->getMessage()],
                 'code' => $e->getCode()
             ], Response::HTTP_INTERNAL_SERVER_ERROR);
         }
     }


     // Chi tiết đơn hàng
    public function getOrderDetails($orderId)
    {
        try {
            $order = Order::with([
                'user',
                'orderDetails',
                'orderDetails.variant',
                'orderDetails.variant.product',
                'orderDetails.variant.weight',
            ])
                ->where('id', $orderId)
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy đơn hàng!'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Danh sách chi tiết đơn hàng',
                'data' => $order
            ], Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi với cơ sở dữ liệu.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi models không tạo.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            // Lỗi hệ thống
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi truy xuất dữ liệu',
                'errors' => [$e->getMessage()],
                'code' => $e->getCode()
            ]);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);
        // $order_detail = OrderDetail::query()->where('order_id',$id)->get();
        // $order_detail = DB::table('order_detail')
        //     ->join('variant', 'order_detail.variant_id', '=', 'variant.id')
        //     ->join('product', 'variant.product_id', '=', 'product.id')
        //     ->where('order_detail.order_id', $id)
        //     ->get();
        // $order_detail = OrderDetail::with('variants','product')->where('order_id',$id)->get();
        $order_detail = OrderDetail::query()
        // ->with('variants')
        ->join('variants','variant_id','=','variants.id')
        ->join('products','product_id','=','products.id')
        ->where('order_id',$id)
        ->get();
        return response()->json([
            'status' => true,
            'message' => 'Chi tiết đơn hàng được lấy thành công',
            'order'=>$order,
            'order_detail'=>$order_detail
        ], Response::HTTP_OK);

    }


    public function edit(string $id)
    {
        
    }


    public function update(Request $request, string $id)
    {
        
    }


    public function destroy(string $id)
    {
        //
    }
}
