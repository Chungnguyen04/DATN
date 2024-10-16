<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    public function cartByUserId($userId)
    {
        try {
            $cartItems = Cart::with([
                'product',
                'variant',
                'user',
            ])->where('user_id', $userId)->get();

            // Kiểm tra nếu giỏ hàng trống
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Giỏ hàng trống.',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => true,
                'message' => 'Danh sách giỏ hàng đã được lấy thành công.',
                'cart_items' => $cartItems,
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
                'message' => 'Lỗi không thấy model.',
                'errors' => [$e->getMessage()],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function addToCart(CartRequest $request)
    {
        try {
            $cartItem = Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công.',
                'cart_item' => $cartItem,
            ], Response::HTTP_CREATED);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_NOT_FOUND);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi với cơ sở dữ liệu.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateQuantity(Request $request)
    {
        try {
            $cartItem = Cart::find($request->cart_id);

            if (!$cartItem) {
                return response()->json([
                    'status' => false,
                    'message' => 'Sản phẩm không tồn tại.',
                ], Response::HTTP_NOT_FOUND);
            }

            $cartItem->update([
                'quantity' => $request->quantity,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Số lượng sản phẩm đã được thay đổi',
                'cart_item' => $cartItem,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Sản phẩm không tồn tại.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_NOT_FOUND);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi với cơ sở dữ liệu.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi, vui lòng thuze.',
                'errors' => [$e->getMessage()],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
