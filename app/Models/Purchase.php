<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Stock;
class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'product_id',
        'quantity',
        'buying_price',
        'unit',
        'exp_date',
        'total',
        'remarks',
        'status'
    ];

    protected static function booted()
    {
        static::created(function ($purchase) {
            $stock = Stock::firstOrNew(['product_id' => $purchase->product_id]);
            $stock->available_stock = ($stock->available_stock ?? 0) + $purchase->quantity;
            $stock->purchase_id = $purchase->id;
            $stock->save();
        });
    }

    public function Product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

}
