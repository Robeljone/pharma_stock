<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Purchase;
class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'product_id',
        'purchase_id',
        'available_stock',
        'status'
    ];
public function Product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
    public function Purchase()
    {
        return $this->hasOne(Purchase::class,'id','purchase_id');
    }


}
