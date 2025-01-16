<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $receipt_id
 * @property int|null $category_id
 * @property string $name
 * @property float $quantity
 * @property mixed $price
 * @property mixed $sale_price
 * @property mixed $total_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $category
 * @property-read Receipt $receipt
 */
class ReceiptItem extends Model
{
    protected $fillable = [
        'receipt_id',
        'category_id',
        'name',
        'quantity',
        'price',
        'sale_price',
        'total_price'
    ];

    protected $casts = [
        'price' => MoneyCast::class,
        'sale_price' => MoneyCast::class,
        'total_price' => MoneyCast::class
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
