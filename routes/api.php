<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::resource('categories', CategoryController::class);
Route::resource('shops', ShopController::class);

Route::group(['prefix' => 'receipts'], function(){
    Route::get('', [ReceiptController::class, 'index']);
    Route::get('{id}', [ReceiptController::class, 'show']);
    Route::post('', [ReceiptController::class, 'store']);
    Route::post('recognize', [ReceiptController::class, 'recognize']);
});

Route::group(['prefix' => 'statistics'], function() {
    Route::get('amount-by-category', [StatisticsController::class, 'getAmountByCategory']);
    Route::get('amount-by-shop', [StatisticsController::class, 'getAmountByShop']);
    Route::get('amount-by-date', [StatisticsController::class, 'getAmountByDate']);
    Route::get('amount-by-month-shop', [StatisticsController::class, 'getAmountByMonthAndShop']);
});
