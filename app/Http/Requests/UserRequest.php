<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $role
 */
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:40',
            'role' => 'required|string'
        ];

        if ($this->isMethod('post')) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['password'] = 'required|min:8';
            $rules['password_confirmation'] = 'required|same:password';
        } elseif ($this->isMethod('put')) {
            $rules['email'] = 'sometimes|email';
            $rules['image'] = 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048';
            $rules['password'] = 'sometimes|nullable|min:8';
            $rules['password_confirmation'] = 'nullable|same:password';
        }

        return $rules;
    }
}
