<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'name')
                    ->where(function ($query) {
                        return $this->branch_id
                            ? $query->where('branch_id', $this->branch_id)
                            : $query->whereNull('branch_id');
                    })
                    ->ignore($productId),
            ],
            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'sku')
                    ->where(function ($query) {
                        return $this->branch_id
                            ? $query->where('branch_id', $this->branch_id)
                            : $query->whereNull('branch_id');
                    })
                    ->ignore($productId),
            ],
            'description' => ['nullable', 'string'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'cost_price' => ['nullable', 'numeric', 'min:0'],
            'stock_qty' => ['required', 'integer', 'min:0'],
            'commission_type' => ['required', 'in:percentage,fixed'],
            'commission_value' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_category_id.required' => 'Product category is required.',
            'name.required' => 'Product name is required.',
            'name.unique' => 'This product name already exists for this branch.',
            'sku.unique' => 'This product SKU already exists for this branch.',
            'selling_price.required' => 'Selling price is required.',
            'stock_qty.required' => 'Stock quantity is required.',
            'commission_type.required' => 'Commission type is required.',
            'commission_value.required' => 'Commission value is required.',
        ];
    }
}
