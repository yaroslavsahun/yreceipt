<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;
class ReceiptDTO extends DataTransferObject
{
    public int $shop_id;
    public float $amount;
    public ?string $created_at;
    public ?string $updated_at;
    public ?UploadedFile $file = null;
    /** @var ReceiptItemDTO[] */
    public array $items;
}
