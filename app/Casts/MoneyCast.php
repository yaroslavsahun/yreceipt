<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MoneyCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return self::deserialize($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return self::serialize($value);
    }

    public static function serialize(mixed $value): float
    {
        return (int) ($value * 100);
    }

    public static function deserialize(mixed $value): float
    {
        return round($value / 100, 2);
    }
}
