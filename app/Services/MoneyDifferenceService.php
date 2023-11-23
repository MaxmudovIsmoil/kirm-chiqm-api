<?php

namespace App\Services;

use App\Http\Resources\DebtorDetailResource;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use App\Models\MoneyDifference;

class MoneyDifferenceService
{

    public function list(int $debtor_id)
    {
        $debtors = MoneyDifference::where(['debtor_id' => $debtor_id])
            ->with('debtor')
            ->get();

        return DebtorDetailResource::collection($debtors);
    }

    public function create(array $data)
    {
        return MoneyDifference::create([
            'debtor_id' => (int) $data['debtor_id'],
            'money' => $data['money'],
            'status' => (int) $data['status'],
        ]);
    }

    public function update(array $data, int $id)
    {
        return MoneyDifference::where(['id'=> $id])
            ->update([
                'debtor_id' => $data['debtor_id'],
                'money' => $data['money'],
                'status' => (int) $data['status'],
            ]);
    }

    public function delete(int $id)
    {
        return DebtorDetail::destroy($id);
    }

}

