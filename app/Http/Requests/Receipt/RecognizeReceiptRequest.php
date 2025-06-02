<?php

namespace App\Http\Requests\Receipt;

use Illuminate\Foundation\Http\FormRequest;

class RecognizeReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['file'],
        ];
    }
}
