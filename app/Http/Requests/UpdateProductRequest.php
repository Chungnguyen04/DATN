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

            'productVariant.weight_id.*' => 'required',
            'productVariant.listed_price.*' => 'required|numeric|gt:0',
            'productVariant.import_price.*' => 'required|numeric|gt:0',
            'productVariant.selling_price.*' => 'required|numeric|gt:0',
            'productVariant.weight.*' => 'required|numeric',
            'productVariant.quantity.*' => 'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'product.name.required' => 'Tên sản phẩm là bắt buộc',
            'product.name.unique' => 'Tên sản phẩm đã tồn tại',

            'product.price.numeric' => 'Giá phải là một số.',
            'product.category_id.required' => 'Danh mục là bắt buộc',

            'productVariant.weight_id.*.required' => 'Trọng lượng là bắt buộc.',

            'productVariant.listed_price.*.required' => 'Giá niêm yết phải là bắt buộc.',
            'productVariant.listed_price.*.numeric' => 'Giá niêm yết phải là một số.',
            'productVariant.listed_price.*.gt' => 'Giá niêm yết phải là > 0.',

            'productVariant.import_price.*.required' => 'Giá nhập phải là bắt buộc.',
            'productVariant.import_price.*.numeric' => 'Giá nhập phải là một số.',
            'productVariant.import_price.*.gt' => 'Giá nhập phải là > 0.',

            'productVariant.selling_price.*.required' => 'Giá bán phải là bắt buộc.',
            'productVariant.selling_price.*.numeric' => 'Giá bán phải là một số.',
            'productVariant.selling_price.*.gt' => 'Giá bán phải là > 0.',

            'productVariant.weight.*.required' => 'Khối lượng phải là bắt buộc.',
            'productVariant.weight.*.numeric' => 'Khối lượng phải là một số.',

            'productVariant.quantity.*.required' => 'Số lượng phải là bắt buộc.',
            'productVariant.quantity.*.numeric' => 'Số lượng phải là một số.',
            'productVariant.quantity.*.gt' => 'Số lượng phải là > 0.',
        ];
    }
}
