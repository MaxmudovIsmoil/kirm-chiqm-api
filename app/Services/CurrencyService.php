<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class CurrencyService
{
    public function list()
    {
        $userId = Auth::user()->id;
        return Currency::where(['user_id' => $userId])
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function last()
    {
        $userId = Auth::user()->id;
        return Currency::where(['user_id' => $userId])
            ->whereNull('deleted_at')
            ->latest()
            ->first();
    }

    public function one(int $id)
    {
        return Currency::findOrFail($id);
    }

    public function create(array $data)
    {
        return Currency::create([
            'user_id' => Auth::user()->id,
            'currency' => $data['currency'],
        ]);

    }

    public function update(array $data, int $id)
    {
        return Currency::where('id', $id)->update(['currency' => $data['currency']]);
    }

    public function delete(int $id)
    {
        return Currency::where(['id' => $id])
            ->update(['deleted_at' => now()]);
    }
}

