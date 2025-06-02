<?php

declare(strict_types=1);

namespace App\Services;

use App\Casts\MoneyCast;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class StatisticsService
{
    public function getAmountByCategory(): Collection
    {
        return Category::query()
            ->join('receipt_items', 'receipt_items.category_id', '=', 'categories.id')
            ->select('categories.*', DB::raw('SUM(receipt_items.total_price) as sum'))
            ->groupBy('categories.id')
            ->get()
            ->map(function ($item) {
                $item->sum = MoneyCast::deserialize($item->sum);
                return $item;
            })
            ->sortByDesc('sum')
            ->values();
    }

    public function getAmountByShop(): Collection
    {
        return Shop::query()
            ->join('receipts', 'receipts.shop_id', '=', 'shops.id')
            ->join('receipt_items', 'receipt_items.receipt_id', '=', 'shops.id')
            ->select('shops.*', DB::raw('SUM(receipt_items.total_price) as sum'))
            ->groupBy('shops.id')
            ->get()
            ->map(function ($item) {
                $item->sum = MoneyCast::deserialize($item->sum);
                return $item;
            })
            ->sortByDesc('sum')
            ->values();
    }
}
