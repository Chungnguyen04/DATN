<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('id');
        return [
            'code' => 'required|string|max:255|unique:vouchers,code,' . $id, // Mã voucher phải duy nhất
            'name' => 'required|string|max:255',                      // Tên voucher
            'discount_value' => 'required|numeric|min:0',             // Giá trị giảm giá phải là số
            'discount_min_price' => 'nullable|numeric|min:0',         // Giá trị đơn hàng tối thiểu
            'discount_type' => 'required|in:all,condition',           // Loại discount phải thuộc 'all' hoặc 'condition'
            'start_date' => 'required|date|before_or_equal:end_date', // Ngày bắt đầu áp dụng phải trước hoặc bằng ngày kết thúc
            'end_date' => 'required|date|after_or_equal:start_date',  // Ngày hết hạn áp dụng phải sau hoặc bằng ngày bắt đầu
            'total_uses' => 'required|integer|min:0',                 // Số lần voucher có thể sử dụng
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã voucher không được để trống.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'code.max' => 'Mã voucher không được vượt quá 255 ký tự.',
            'name.required' => 'Tên voucher không được để trống.',
            'discount_value.required' => 'Giá trị giảm giá không được để trống.',
            'discount_value.numeric' => 'Giá trị giảm giá phải là một số.',
            'discount_min_price.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
            'discount_type.required' => 'Loại voucher không được để trống.',
            'discount_type.in' => 'Loại voucher không hợp lệ.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'start_date.date' => 'Ngày bắt đầu phải là định dạng ngày.',
            'start_date.before_or_equal' => 'Ngày bắt đầu phải trước hoặc bằng ngày kết thúc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',
            'end_date.date' => 'Ngày kết thúc phải là định dạng ngày.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'total_uses.required' => 'Số lần sử dụng không được để trống.',
            'total_uses.integer' => 'Số lần sử dụng phải là một số nguyên.',
            'total_uses.min' => 'Số lần sử dụng phải lớn hơn hoặc bằng 0.',
        ];
    }
}
