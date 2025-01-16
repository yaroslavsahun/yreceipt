<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $shop_id
 * @property mixed $amount
 * @property string|null $file_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ReceiptItem> $items
 * @property-read int|null $items_count
 * @property-read Shop|null $shop
 */
class Receipt extends Model
{
    protected $fillable = ['shop_id', 'amount', 'file_path'];

    protected $casts = [
        'amount' => MoneyCast::class
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReceiptItem::class);
    }
}
