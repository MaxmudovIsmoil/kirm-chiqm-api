<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyDifference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'debtor_id',
        'money',
        'status'
    ];
}
