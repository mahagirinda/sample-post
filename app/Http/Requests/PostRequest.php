<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $id
 * @property string $title
 * @property file image
 * @property string category
 * @property string post_content
 */
class PostRequest extends FormRequest
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
            'title' => 'required|string|min:5|max:255',
            'category' => 'required|string|min:3|max:255',
            'post_content' => 'required|string',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($this->isMethod('put')) {
            $rules['image'] = 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }
}
