<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoucherController extends Controller
{

    public function index()
    {
        $vouchers = Voucher::orderBy('id', 'desc')->paginate(10);
        return view('Admin.pages.vouchers.index', compact('vouchers'));
    
    }

    public function create()
    {
        return view('Admin.pages.vouchers.create');
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Voucher::create([
                'code' => $request->code,
                'name' => $request->name,
                'discount_value' => $request->discount_value,
                'discount_min_price' => $request->discount_min_price,
                'discount_type' => $request->discount_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_uses' => $request->total_uses,
            ]);

            DB::commit();

            return redirect()->route('vouchers.index')->with('status_succeed', 'Thêm voucher thành công');
        } catch (\Exception $e) {
            DB::rollback();

            Log::error($e->getMessage());

            return back()->with('status_failed', 'Đã xảy ra lỗi!');
        }
    }


    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }
}
