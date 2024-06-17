<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $detail
 * @property mixed $status
 */
class CategoryRequest extends FormRequest
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
            'detail' => 'required|string|min:3|max:200'
        ];

        if ($this->isMethod('post')) {
            $rules['name'] = 'required|string|min:3|max:40|unique:categories,name';
        } elseif ($this->isMethod('put')) {
            $rules['name'] = 'sometimes|string|min:3|max:40';
        }

        return $rules;
    }
}
