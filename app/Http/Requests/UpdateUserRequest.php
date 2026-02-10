<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to false if you need authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id'); // Get the user ID from route parameter
        return [
            'organization_id' => 'sometimes|integer|exists:organizations,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'sometimes|string|in:admin,teacher,student',
            'avatar' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'organization_id.integer' => 'Organization ID must be a number.',
            'organization_id.exists' => 'Selected organization does not exist.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot be longer than 255 characters.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.min' => 'Password must be at least 8 characters.',
            'phone.max' => 'Phone number cannot be longer than 20 characters.',
            'role.in' => 'Role must be admin, teacher, or student.',
            'is_active.boolean' => 'Status must be true or false.',
        ];
    }

    /**
     * Get custom attribute names for validation.
     */
    public function attributes(): array
    {
        return [
            'organization_id' => 'organization',
            'is_active' => 'status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Only merge is_active if it's present in the request
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => $this->boolean('is_active'),
            ]);
        }
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
