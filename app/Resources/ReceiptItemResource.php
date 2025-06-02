<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\ReceiptItem;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin ReceiptItem */
class ReceiptItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'category' => CategoryResource::make($this->category),
            'name' => $this->name,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
