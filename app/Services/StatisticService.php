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
            ->join('debtors', 'debtor_details.debtor_id', '=', 'debtors.id')
            ->select('debtor_details.status', DB::raw('SUM(debtor_details.money) as total_amount'))
            ->where('debtors.user_id', Auth::id())
            ->whereNull('debtor_details.deleted_at')
            ->whereMonth('debtor_details.date', $month)
            ->groupBy('debtor_details.status')
            ->get();
    }

    public function debtorMonth(int $debtorId, string $month = null): object
    {
        if ($month == null)
            $month = Carbon::now()->subMonth()->month;

        return DB::table('debtor_details')
            ->join('debtors', 'debtor_details.debtor_id', '=', 'debtors.id')
            ->select('debtor_details.status', DB::raw('SUM(debtor_details.money) as total_amount'))
            ->where('debtors.user_id', Auth::id())
            ->where(['debtors.id' => $debtorId])
            ->whereNull('debtor_details.deleted_at')
            ->whereMonth('debtor_details.date', $month)
            ->groupBy('debtor_details.status')
            ->get();
    }

}

