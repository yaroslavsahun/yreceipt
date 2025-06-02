<?php

declare(strict_types=1);

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ReceiptItemDTO extends DataTransferObject
{
    public ?int $category_id;
    public string $name;
    public float $quantity;
    public float $price;
    public ?float $sale_price;
}
