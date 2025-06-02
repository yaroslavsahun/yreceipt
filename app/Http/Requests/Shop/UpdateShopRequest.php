<?php

namespace App\Http\Requests\Shop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:shops,name,' . $this->route('shop')],
            'logo' => ['image'],
            'color' => ['required', 'string'],
        ];
    }
}
