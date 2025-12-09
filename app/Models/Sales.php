<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Sales extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'product_id',
        'product_price_key',   // add this
        'quantity',
        'buying_price',
        'selling_price',
        'buy_total',
        'sell_price',
        'profit',
        'sales_date',
        'remarks'
    ];

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // keep original value
        $data['product_price_key'] = $data['product_id'];

        list($productId, $buyingPrice) = explode('|', $data['product_id']);

        $data['product_id'] = $productId;
        $data['buying_price'] = $buyingPrice;
        $data['buy_total'] = $data['quantity'] * $buyingPrice;
        $data['profit'] = ($data['quantity'] * $data['sell_price']) - ($data['quantity'] * $buyingPrice);

        return $data;
    }

    protected static function booted()
    {
        static::created(function ($sale) {

            list($productId, $buyingPrice) = explode('|', $sale->product_price_key);

            // get correct stock batch
            $stock = Stock::where('product_id', $productId)
                ->whereHas('purchase', fn($q) => $q->where('buying_price', $buyingPrice))
                ->orderByDesc('id')
                ->first();

            if (! $stock) {
                throw new \Exception("Stock not found for this product and price.");
            }

            if ($sale->quantity > $stock->available_stock) {
                throw new \Exception("Only {$stock->available_stock} items available.");
            }

            $stock->available_stock -= $sale->quantity;
            $stock->save();
        });
    }
}
