<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/** @mixin Category */
class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => Storage::url($this->logo),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
