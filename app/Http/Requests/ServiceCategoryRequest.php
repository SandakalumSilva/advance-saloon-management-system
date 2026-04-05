<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Mime\Message;

class ServiceCategoryRequest extends FormRequest
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
        $serviceCategoryId = $this->route('serviceCategory')?->id;

        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_categories', 'name')
                    ->where(fn($query) => $query->where('branch_id', $this->branch_id))
                    ->ignore($serviceCategoryId),
            ],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Category Name required."
        ];
    }
}
