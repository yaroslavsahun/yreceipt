<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property string|null $logo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Category extends Model
{
    protected $fillable = ['name', 'logo', 'color'];
}
