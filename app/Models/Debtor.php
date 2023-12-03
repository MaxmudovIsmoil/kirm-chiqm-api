<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Debtor extends Model
{
    use HasFactory;

//    public $table = 'debtors';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'status',
        'money',
        'deleted_at'
    ];

    public function debtor_detail()
    {
        return $this->hasMany(DebtorDetail::class, 'debtor_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

