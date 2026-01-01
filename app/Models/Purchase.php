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
        static::created(function ($purchase) 
        {
        $latestStock = Stock::where('product_id', $purchase->product_id)
        ->where('price',$purchase->buying_price)
        ->first();

    if ($latestStock)
    {
        $latestPurchase = Purchase::find($latestStock->purchase_id);
        if ($latestPurchase && $latestPurchase->buying_price == $purchase->buying_price)
        {
            $latestStock->purchase_id = $latestPurchase->id;
            $latestStock->available_stock += $purchase->quantity;
            $latestStock->save();
        } else {
            $newStock = new Stock();
            $newStock->product_id = $purchase->product_id;
            $newStock->available_stock = $purchase->quantity;
            $newStock->purchase_id = $purchase->id;
            $newStock->price = $purchase->buying_price;
            $newStock->save();
        }
    } else {
        $newStock = new Stock();
        $newStock->product_id = $purchase->product_id;
        $newStock->available_stock = $purchase->quantity;
        $newStock->purchase_id = $purchase->id;
        $newStock->price = $purchase->buying_price;
        $newStock->save();
    }
});

    }

    public function Product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

}
