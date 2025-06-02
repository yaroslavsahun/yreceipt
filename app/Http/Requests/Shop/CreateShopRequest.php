<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class CreateShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:shops,name'],
            'logo' => ['required', 'image'],
            'color' => ['required', 'string'],
        ];
    }
}
