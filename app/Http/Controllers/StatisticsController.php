<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(private readonly StatisticsService $service)
    {
    }

    public function getAmountByCategory(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $this->service->getAmountByCategory()]);
    }

    public function getAmountByShop(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $this->service->getAmountByShop()]);
    }
}
