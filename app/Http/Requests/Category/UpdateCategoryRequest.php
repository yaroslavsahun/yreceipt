<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:categories,name,' . $this->route('category')],
            'logo' => ['image'],
            'color' => ['required', 'string'],
        ];
    }
}
