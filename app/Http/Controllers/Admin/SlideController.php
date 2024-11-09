<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $data['sliders'] = Slider::orderBy('id', 'DESC')->paginate(5);
        return view('admin.pages.sliders.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pages.sliders.create');
    }

    public function store(SlideRequest $request)
    {
        try {
            DB::beginTransaction();

            // Kiểm tra trùng lặp tiêu đề
            $duplicateTitle = Slider::where('title', $request->title)->first();

            // Kiểm tra trùng lặp ảnh
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('sliders', 'public');
                $imageName = basename($imagePath);
                $duplicateImage = Slider::where('image', 'sliders/' . $imageName)->first();

                if ($duplicateTitle || $duplicateImage) {
                    return back()->with('status_failed', 'Tiêu đề hoặc ảnh đã tồn tại!');
                }
            } else {
                if ($duplicateTitle) {
                    return back()->with('status_failed', 'Tiêu đề đã tồn tại!');
                }
            }

            $slider = new Slider();
            $slider->title = $request->title;
            $slider->link = $request->link;

            // Xử lý upload ảnh
            if ($request->hasFile('image')) {
                $slider->image = $imagePath;
            }

            $slider->save();
            DB::commit();
            return redirect()->route('sliders.index')->with('status_succeed', 'Thêm mới slide thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->with('status_failed', 'Đã xảy ra lỗi!');
        }
    }

    public function edit($id)
    {
        $data['slider'] = Slider::findOrFail($id);
        return view('admin.pages.sliders.edit', compact('data'));
    }

    public function update(SlideRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $slider = Slider::findOrFail($id);

            // Kiểm tra trùng lặp tiêu đề (bỏ qua slide hiện tại)
            $duplicateTitle = Slider::where('title', $request->title)
                ->where('id', '!=', $id)
                ->first();

            // Kiểm tra trùng lặp ảnh (bỏ qua slide hiện tại)
            $imagePath = $slider->image; // Giữ lại ảnh cũ nếu không có ảnh mới
            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('sliders', 'public');
                $newImageName = basename($newImagePath);
                $duplicateImage = Slider::where('image', 'sliders/' . $newImageName)
                    ->where('id', '!=', $id)
                    ->first();

                if ($duplicateTitle || $duplicateImage) {
                    return back()->with('status_failed', 'Tiêu đề hoặc ảnh đã tồn tại!');
                }

                // Xóa ảnh cũ nếu có ảnh mới
                if (Storage::disk('public')->exists($slider->image)) {
                    Storage::disk('public')->delete($slider->image);
                }
                $imagePath = $newImagePath; // Cập nhật đường dẫn ảnh mới
            } elseif ($duplicateTitle) {
                return back()->with('status_failed', 'Tiêu đề đã tồn tại!');
            }

            $slider->title = $request->title;
            $slider->link = $request->link;
            $slider->image = $imagePath;

            $slider->save();
            DB::commit();
            return redirect()->route('sliders.index')->with('status_succeed', 'Cập nhật slide thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->with('status_failed', 'Đã xảy ra lỗi!');
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $slider = Slider::findOrFail($id);
            if (Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $slider->delete();

            DB::commit();
            return redirect()->route('sliders.index')->with('status_succeed', 'Xóa slide thành công');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return back()->with('status_failed', 'Đã xảy ra lỗi!');
        }
    }
}
