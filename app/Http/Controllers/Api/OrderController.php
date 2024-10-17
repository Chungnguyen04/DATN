<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(string $id)
    {

            $orders = Order::query()->where('user_id',$id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Đơn hàng được lấy thành công',
                'data' => $orders
            ], Response::HTTP_OK);

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
