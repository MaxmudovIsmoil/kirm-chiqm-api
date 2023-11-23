<?php

namespace App\Services;

use App\Http\Resources\DebtorDetailResource;
use App\Models\DebtorDetail;

class DebtorDetailService
{

    public function list(int $debtor_id)
    {
        $debtors = DebtorDetail::where(['debtor_id' => $debtor_id])
            ->with('debtor')
            ->get();

        return DebtorDetailResource::collection($debtors);
    }

    public function create(array $data)
    {
        return DebtorDetail::create([
            'debtor_id' => (int) $data['debtor_id'],
            'money' => $data['money'],
            'status' => (int) $data['status'],
        ]);
    }

    public function update(array $data, int $id)
    {
        return DebtorDetail::where(['id'=> $id])
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

