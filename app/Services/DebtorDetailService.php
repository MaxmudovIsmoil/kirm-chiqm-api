<?php

namespace App\Services;

use App\Http\Resources\DebtorDetailResource;
use App\Models\DebtorDetail;
use Illuminate\Support\Str;

class DebtorDetailService
{

    public function list(int $debtor_id)
    {
        $debtors = DebtorDetail::where(['debtor_id' => $debtor_id])
            ->with('debtor', 'currency')
            ->get();

        return DebtorDetailResource::collection($debtors);
    }

    public function create(array $data)
    {
        $expression_history = Str::replace(' ', '+', trim($data['expression_history']));
        return DebtorDetail::create([
            'debtor_id' => (int) $data['debtor_id'],
            'money' => $data['money'],
            'status' => $data['status'],
            'date' => $data['date'],
            'expression_history' => $expression_history,
            'currency_id' => $data['currency_id'],
        ]);
    }

    public function update(array $data, int $id)
    {
        $expression_history = Str::replace(' ', '+', trim($data['expression_history']));
        return DebtorDetail::where(['id'=> $id])
            ->update([
                'debtor_id' => $data['debtor_id'],
                'money' => $data['money'],
                'status' => $data['status'],
                'date' => $data['date'],
                'currency_id' => $data['currency_id'],
                'expression_history' => $expression_history,
            ]);
    }

    public function delete(int $id)
    {
        return DebtorDetail::destroy($id);
    }

}

