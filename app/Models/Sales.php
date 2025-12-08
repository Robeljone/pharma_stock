<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'quantity',
        'buying_price',
        'selling_price',
        'buy_total',
        'sell_price',
        'profit',
        'sales_date',
        'remarks'
    ];
}
