<?php

namespace App\Http\Requests\Receipt;

use App\DTO\ReceiptDTO;
use App\DTO\ReceiptItemDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CreateReceiptRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['nullable', 'file'],
            'shop_id' => ['required', 'integer', 'exists:shops,id'],
            'amount' => ['required', 'numeric'],
            'items' => ['required', 'array'],
            'items.*.category_id' => ['required', 'integer', 'exists:categories,id'],
            'items.*.name' => ['required', 'string'],
            'items.*.quantity' => ['required', 'numeric'],
            'items.*.price' => ['required', 'numeric'],
        ];
    }

    public function prepareForValidation(): void
    {
        Log::info($this->input());
        $amount = 0;

        foreach($this->input('items') as $item){
            $amount += $item['quantity'] * $item['price'];
        }

        $this->merge([
            'amount' => $amount,
        ]);
    }

    public function getDTO(): ReceiptDTO
    {
        return new ReceiptDTO([
            'shop_id' => $this->input('shop_id'),
            'amount' => $this->input('amount'),
            'file' => $this->file('file'),
            'items' => array_map(function ($item) {
                return new ReceiptItemDTO($item);
            }, $this->input('items')),
        ]);
    }
}
