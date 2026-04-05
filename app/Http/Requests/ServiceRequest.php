<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
        $serviceId = $this->route('service')?->id;

        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')
                    ->where(function ($query) {
                        return $this->branch_id
                            ? $query->where('branch_id', $this->branch_id)
                            : $query->whereNull('branch_id');
                    })
                    ->ignore($serviceId),
            ],
            'code' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'code')
                    ->where(function ($query) {
                        return $this->branch_id
                            ? $query->where('branch_id', $this->branch_id)
                            : $query->whereNull('branch_id');
                    })
                    ->ignore($serviceId),
            ],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'commission_type' => ['required', 'in:percentage,fixed'],
            'commission_value' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_category_id.required' => 'Service category is required.',
            'name.required' => 'Service name is required.',
            'name.unique' => 'This service name already exists for this branch.',
            'code.unique' => 'This service code already exists for this branch.',
            'duration_minutes.required' => 'Duration is required.',
            'price.required' => 'Price is required.',
            'commission_type.required' => 'Commission type is required.',
            'commission_value.required' => 'Commission value is required.',
        ];
    }
}
