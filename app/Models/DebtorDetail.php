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
        'status'
    ];

    public function debtor()
    {
        return $this->hasOne(Debtor::class, 'id', 'debtor_id');
    }
}
