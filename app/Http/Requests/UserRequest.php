<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->route('user'))],
            'phone' => ['required', 'digits:10'],
            'role' => ['required', 'exists:roles,name'],
            'branch_id' => ['required', 'exists:branches,id'],

            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'join_date' => ['nullable', 'date'],
            'basic_salary' => ['nullable', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'branch_id.required' => 'Please select a branch',
            'role.required' => 'Please select a role',
            'phone.digits' => 'Phone must be exactly 10 digits',
        ];
    }
}
