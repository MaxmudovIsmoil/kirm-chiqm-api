<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\DebtorDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    public function month(string $month = null): object
    {
        if ($month == null)
            $month = Carbon::now()->subMonth()->month;

        return DB::table('debtor_details')
            ->select('status', DB::raw('SUM(money) as total_amount'))
            ->whereMonth('date', $month)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();
    }

    public function debtorMonth(int $debtorId, string $month = null): object
    {
        if ($month == null)
            $month = Carbon::now()->subMonth()->month;

        return DB::table('debtor_details')
            ->select('status', DB::raw('SUM(money) as total_amount'))
            ->where(['debtor_id' => $debtorId])
            ->whereNull('deleted_at')
            ->whereMonth('date', $month)
            ->groupBy('status')
            ->get();
    }

}

