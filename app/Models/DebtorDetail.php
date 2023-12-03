<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtorDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'debtor_id',
        'money',
        'status',
        'currency_id',
        'expression_history',
        'date',
        'deleted_at'
    ];

    public function debtor()
    {
        return $this->hasOne(Debtor::class, 'id', 'debtor_id');
    }


    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
