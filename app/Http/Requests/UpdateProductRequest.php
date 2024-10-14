<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'product.name' => 'required|unique:products,name,' . $id,
            'product.price' => 'nullable|numeric',
            'product.category_id' => 'required',

            'productVariant.listed_price.*' => 'nullable|numeric',
            'productVariant.import_price.*' => 'nullable|numeric',
            'productVariant.selling_price.*' => 'nullable|numeric',
            'productVariant.weight.*' => 'nullable|numeric',
            'productVariant.quantity.*' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'product.name.required' => 'Tên sản phẩm là bắt buộc',
            'product.name.unique' => 'Tên sản phẩm đã tồn tại',

            'product.price.numeric' => 'Giá phải là một số.',
            'product.category_id.required' => 'Danh mục là bắt buộc',

            // Thông báo lỗi cho biến thể
            'productVariant.listed_price.*.numeric' => 'Giá niêm yết phải là một số.',

            'productVariant.import_price.*.numeric' => 'Giá nhập phải là một số.',

            'productVariant.selling_price.*.numeric' => 'Giá bán phải là một số.',

            'productVariant.weight.*.numeric' => 'Khối lượng phải là một số.',

            'productVariant.quantity.*.numeric' => 'Số lượng phải là một số.',
        ];
    }
}
