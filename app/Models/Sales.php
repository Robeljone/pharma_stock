<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'product_price_key',
        'quantity',
        'buying_price',
        'selling_price',
        'buy_total',
        'sell_total',
        'profit',
        'sales_date',
        'remarks'
    ];

}
