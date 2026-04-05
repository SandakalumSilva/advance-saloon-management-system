<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        $customerId = $this->route('customer')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('customers', 'phone')->ignore($customerId),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => $this->filled('email') ? $this->email : null,
            'last_name' => $this->filled('last_name') ? $this->last_name : null,
            'address' => $this->filled('address') ? $this->address : null,
            'notes' => $this->filled('notes') ? $this->notes : null,
            'status' => $this->boolean('status'),
        ]);
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number already exists.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'This email already exists.',
        ];
    }
}
