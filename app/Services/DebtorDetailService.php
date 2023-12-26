<?php

namespace App\Services;

use App\Http\Resources\DebtorDetailResource;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DebtorDetailService
{
    public function __construct(
        public CurrencyService $currency
    )
    {}
    public function list(int $debtorId)
    {
        $debtors = DebtorDetail::where(['debtor_id' => $debtorId])
            ->whereNull('deleted_at')
            ->with('debtor', 'currency')
            ->orderBy('id', 'DESC')
            ->get();

        return DebtorDetailResource::collection($debtors);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
            $debtorId = (int) $data['debtor_id'];
            $status = $data['status'];
            $currency_convert = $data['currency_convert'];
            $currencyId = (int) $data['currency_id'];
            $money = $data['money'];
            $expression_history = Str::replace(' ', '+', trim($data['expression_history']));

            $d = DebtorDetail::create([
                'debtor_id' => $debtorId,
                'money' => $money,
                'status' => $status,
                'date' => $data['date'],
                'expression_history' => $expression_history,
                'currency_convert' => $currency_convert,
                'currency_id' => $currencyId,
            ]);

            $this->newMoneyAddDebtor($debtorId, $currency_convert, $currencyId, $money, $status);
        DB::commit();
        return $d;

    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
            $debtorId = $data['debtor_id'];
            $status = $data['status'];
            $money = $data['money'];
            $currency_convert = $data['currency_convert'];
            $currencyId = (int) $data['currency_id'];
            $expression_history = Str::replace(' ', '+', trim($data['expression_history']));
            $debtorDetail = DebtorDetail::findOrFail($id);

            // old remove
            $this->oldMoneyRemoveDebtor($debtorDetail);
            // mew add
            $this->newMoneyAddDebtor($debtorId, $currency_convert, $currencyId, $money, $status);

            $debtorDetail->update([
                'debtor_id' => $debtorId,
                'money' => $money,
                'status' => $status,
                'date' => $data['date'],
                'currency_convert' => $currency_convert,
                'currency_id' => $currencyId,
                'expression_history' => $expression_history,
            ]);
        DB::commit();
        return $debtorDetail;
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
            $debtorDetail = DebtorDetail::findOrfail($id);

            // old remove
            $this->oldMoneyRemoveDebtor($debtorDetail);

            $debtorDetail->update(['deleted_at' => now()]);
        DB::commit();
        return $debtorDetail;
    }


    public function newMoneyAddDebtor(
        int $debtorId,
        string $currency_convert,
        int $currency_id,
        string $money,
        string $status
    ): void
    {
        if ($currency_convert == 1) {
            $currency = $this->currency->one($currency_id)->currency;
            $money *= $currency;
        }

        $debtor = Debtor::findOrFail($debtorId);

        $money = ($status == 1) ? $debtor->money + $money : $debtor->money - $money;

        $debtor->update(['money' => $money]);
    }

    public function oldMoneyRemoveDebtor(object $debtorDetail): void
    {
        $old_currency_convert = $debtorDetail->currency_convert;
        if ($old_currency_convert == 1) {
            $old_currency_id = (int) $debtorDetail->currency_id;
            $old_currency = $this->currency->one($old_currency_id)->currency;
            $old_money = $debtorDetail->money * $old_currency;
        }
        else {
            $old_money = $debtorDetail->money;
        }

        $debtor = Debtor::findOrfail($debtorDetail->debtor_id);

        $money = ($debtorDetail->status == 1) ? $debtor->money - $old_money : $debtor->money + $old_money;

        $debtor->update(['money' => $money]);
    }
}

