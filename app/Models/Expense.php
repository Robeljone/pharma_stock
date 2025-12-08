<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'exp_name',
        'amount',
        'reason',
        'remarks',
        'date',
        'status'
    ];
}
