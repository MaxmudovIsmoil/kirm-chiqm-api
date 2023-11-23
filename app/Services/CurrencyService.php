<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class CurrencyService
{
    public function list()
    {
        $user_id = Auth::user()->id;

        return Currency::where(['user_id' => $user_id])->latest()->first();
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
        return Currency::destroy($id);
    }
}

