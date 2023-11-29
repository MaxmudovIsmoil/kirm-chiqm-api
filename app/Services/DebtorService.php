<?php

namespace App\Services;

use App\Dto\Debtor\CreateDebtorDto;
use App\Http\Resources\DebtorResource;
use App\Models\Debtor;
use App\Models\DebtorDetail;
use Illuminate\Support\Facades\Auth;

class DebtorService
{

    public function list()
    {
        $user_id = Auth::user()->id;

        $debtors = Debtor::where(['user_id' => $user_id])
            ->with('user')
            ->get();

        return DebtorResource::collection($debtors);
    }

    public function create(CreateDebtorDto $dto)
    {
        return Debtor::create([
            'user_id' => Auth::user()->id,
            'name' => $dto->name,
            'phone' => $dto->phone,
            'status' => (int) $dto->status,
        ]);

    }

    public function update(CreateDebtorDto $dto, int $id)
    {
        return Debtor::where(['id'=> $id])
            ->update([
                'name' => $dto->name,
                'phone' => $dto->phone,
                'status' => (int) $dto->status,
            ]);
    }

    public function delete(int $id)
    {
        DebtorDetail::where(['debtor_id' => $id])->delete();
        return Debtor::destroy($id);
    }
}

