<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catgory;
class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'status'
    ];
    public function Category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
}
