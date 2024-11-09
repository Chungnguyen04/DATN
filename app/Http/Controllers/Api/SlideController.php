<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideRequest;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        // Trả về danh sách sliders với phân trang
        $sliders = Slider::orderBy('id', 'DESC')->paginate(5);
        return response()->json($sliders);
    }


    public function show($id)
    {
        // Trả về thông tin của một slider cụ thể
        $slider = Slider::findOrFail($id);
        return response()->json($slider);
    }

    

}
