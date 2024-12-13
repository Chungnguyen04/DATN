<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GhtkController extends Controller
{
    public function calculateShippingFee(Request $request)
    {
            // Lấy thông tin tỉnh, huyện, xã từ cơ sở dữ liệu
            $province = Province::find($request->province_id);
            $district = District::find($request->district_id);
            $ward = Ward::find($request->ward_id);

        if (!$province || !$district || !$ward) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin tỉnh, huyện, xã không hợp lệ',
            ], 400);
        }

        $data = [
            'pick_province' => 'Hà Nội', // Tỉnh của kho hàng
            'pick_district' => 'Quận Ba Đình', // Quận của kho hàng
            'province' => $province->name, // Tên tỉnh lấy từ cơ sở dữ liệu
            'district' => $district->name, // Tên huyện lấy từ cơ sở dữ liệu
            'ward' => $ward->name, // Tên xã lấy từ cơ sở dữ liệu
            'weight' => 1000, // Trọng lượng gói hàng (gram)
            'value' => 500000, // Giá trị gói hàng
        ];

        $client = new Client();
        try {
            // Gọi API của GHTK để tính phí ship
            $response = $client->post('https://services.giaohangtietkiem.vn/services/shipment/fee', [
                'headers' => [
                    'Token' => '8PXp6P8WEvdfsjJszwfPRSZJyE0qpRXrym2FJS',
                ],
                'form_params' => $data,
            ]);

            $result = json_decode($response->getBody()->getContents(), true);

            Log::debug('API Response:', $result);  // Kiểm tra lại phản hồi

            if (isset($result['success']) && $result['success'] == true) {
                // Trả về phí ship nếu thành công
                if (isset($result['fee']['fee'])) {
                    return response()->json([
                        'success' => true,
                        'fee' => $result['fee']['fee'],  // Lấy phí ship từ 'fee' -> 'fee'
                        'shipMoneyText' => $result['fee']['options']['shipMoneyText'],  // Văn bản hiển thị phí ship
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không có phí ship trong phản hồi',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Không thể tính phí ship',
                ]);
            }
        } catch (\Exception $e) {
return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gọi API tính phí ship: ' . $e->getMessage(),
            ]);
        }
    }

    public function autocomplete(Request $request)
    {
        $input = $request->input('input');
        $apiKey = env('GOOGLE_PLACES_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/place/autocomplete/json";
        $response = Http::get($url, [
            'input' => $input,
            'key' => $apiKey,
        ]);

        // Kiểm tra kết quả API
        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Lỗi khi gọi Google API'], 500);
        }
    }


    public function getProvinces(Request $request)
    {
        $provinces = Province::all();
        return response()->json([
            'provinces' => $provinces
        ]);
    }

    public function getDistricts(Request $request)
    {
        $districts = District::where('province_id', $request->province_id)->get();
        return response()->json([
            'districts' => $districts
        ]);
    }

    public function getWards(Request $request)
    {
        $wards = Ward::where('district_id', $request->district_id)->get();
        return response()->json([
            'wards' => $wards
        ]);
    }
}