<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Product;

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
    protected static function booted()
    {
        static::created(function ($sale)
        {
            $latestStock = Stock::where('product_id', $sale->product_id)
            ->where('price',$sale->buying_price)
            ->first();

        if ($latestStock)
        {
            $latestStock->available_stock -= $sale->quantity;
            $latestStock->save();
        }
      });
    }

    public function Product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
