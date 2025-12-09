<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use App\Models\Purchase;
use App\Models\Stock;
class SalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_select')
                ->label('Product (Name | Buying Price | Stock)')
               ->options(function () {
                    return Purchase::with('product')
                        ->get()
                        ->groupBy(fn($i) => $i->product_id . '-' . $i->buying_price)
                        ->mapWithKeys(function ($group) {

                            $purchase = $group->first();

                            $totalStock = Stock::whereIn('purchase_id', $group->pluck('id'))
                                ->sum('available_stock');

                            // VALUE contains: product_id|price
                            $value = $purchase->product_id.'|'.$purchase->buying_price;

                            return [
                                $value =>
                                    $purchase->product->name . ' | ' .
                                    number_format($purchase->buying_price, 2) . ' Birr | ' .
                                    $totalStock . ' quantity'
                            ];
                        });
                    })
                     ->reactive()
                     ->afterStateUpdated(function ($state, $set) {
                         list($id, $price) = explode('|', $state);
                         $set('product_id', (int)$id);
                         $set('buying_price', (float)$price);
                         $quantity = $get('quantity') ?? 0;
                         $sellingPrice = $get('selling_price') ?? 0;
                         $set('buy_total', $quantity * $buyingPrice);
                         $set('profit', ($quantity * $sellingPrice) - ($quantity * $buyingPrice));
                     })
                     ->searchable(),
                   Hidden::make('product_id'),
                   Hidden::make('buying_price'),
                   TextInput::make('buying_price')->hidden(),
                   TextInput::make('buy_total')->hidden(),
                   TextInput::make('profit')->hidden(),
                   TextInput::make('quantity')
                       ->required()
                       ->numeric(),
                   TextInput::make('selling_price')
                       ->required()
                       ->numeric()
                       ->prefix('$'),
                   DatePicker::make('sales_date')
                       ->required(),
                   Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);

    }
}
