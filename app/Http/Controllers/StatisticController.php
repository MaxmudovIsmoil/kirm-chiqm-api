<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use App\Models\Debtor;
use App\Services\StatisticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function __construct(
        public StatisticService $service
    ) {}

    public function debtor(int $id, string $month = null): JsonResponse
    {
        return response()->success($this->service->debtorMonth($id, $month));
    }


    public function month(string $month = null)
    {
        return response()->success($this->service->month($month));
    }

}
