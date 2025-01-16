<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('shops', ShopController::class);
