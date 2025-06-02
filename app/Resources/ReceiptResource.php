<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\Receipt;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Receipt */
class ReceiptResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'shop' => ShopResource::make($this->shop),
            'amount' => $this->amount,
            'file_path' => Storage::url($this->file_path),
            'items' => ReceiptItemResource::collection($this->items),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
