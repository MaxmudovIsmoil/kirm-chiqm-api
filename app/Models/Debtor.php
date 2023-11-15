<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;

//    public $table = 'debtors';

    protected $fillable = [
      'user_id',
      'name',
      'phone',
      'status'
    ];
}

