<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|min:3|max:200',
            'slug' => 'required|string|unique:blog_categories,slug',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:200',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string',
            'status' => 'required|boolean',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['slug'] = 'required|string|unique:blog_categories,slug,' . $this->route('blog_category');
        }

        return $rules;
    }
}
