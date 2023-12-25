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
            $currency_convert = $data['currency_convert'];
            $currencyId = (int) $data['currency_id'];
            $money = $data['money'];
            $expression_history = Str::replace(' ', '+', trim($data['expression_history']));
            $d = DebtorDetail::create([
                'debtor_id' => $debtorId,
                'money' => $money,
                'status' => $data['status'],
                'date' => $data['date'],
                'expression_history' => $expression_history,
                'currency_convert' => $currency_convert,
                'currency_id' => $currencyId,
            ]);

            $debtor = Debtor::findOrFail($debtorId);
            $this->newMoneyAddDebtor($debtor, $currency_convert, $currencyId, $money);
        DB::commit();
        return $d;

    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
            $debtorId = $data['debtor_id'];
            $expression_history = Str::replace(' ', '+', trim($data['expression_history']));
            $debtorDetail = DebtorDetail::findOrFail($id);

            // old remove
            $old_money = $this->getOldMoneyDebtor($debtorDetail);
            $debtor = Debtor::findOrfail($debtorId);
            $debtor->money -= $old_money * 1;
            Log::info('old_many: '. $old_money);
            Log::info('$debtor->money: '. $debtor->money);

            // mew add
            $money = $data['money'];
            $currency_convert = $data['currency_convert'];
            $currencyId = (int) $data['currency_id'];
            $this->newMoneyAddDebtor($debtor, $currency_convert, $currencyId, $money);


            $debtorDetail->update([
                'debtor_id' => $debtorId,
                'money' => $money,
                'status' => $data['status'],
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
            $old_money = $this->getOldMoneyDebtor($debtorDetail);
            $debtor = Debtor::findOrfail($debtorDetail->debtor_id);
            $debtor->money -= $old_money;
            $debtor->update(['money' => $debtor->money]);

            $debtorDetail->update(['deleted_at' => now()]);
        DB::commit();
        return $debtorDetail;
    }


    public function newMoneyAddDebtor(object $debtor, string $currency_convert, int $currency_id, string $money): void
    {
        if ($currency_convert == 1) {
            $currency = $this->currency->one($currency_id)->currency;
            $money *= $currency;
        }
        $debtor->update(['money' => $debtor->money + $money]);
    }

    public function getOldMoneyDebtor(object $debtorDetail): string
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
        return $old_money;
    }
}

