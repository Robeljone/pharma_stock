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
                    ->afterStateUpdated(function ($state, $set, $get) {
                        if (str_contains($state, '|')) {
                            [$id, $buyingPrice] = explode('|', $state);

                            $set('product_id', (int)$id);
                            $set('buying_price', (float)$buyingPrice);

                            // Get current quantity and selling_price safely
                            $quantity = $get('quantity') ?? 0;
                            $sellingPrice = $get('selling_price') ?? 0;

                            $set('buy_total', $quantity * $buyingPrice);
                            $set('sell_total', $quantity * $sellingPrice);
                            $set('profit', ($quantity * $sellingPrice) - ($quantity * $buyingPrice));
                        }
                    })
                    ->searchable(),

                Hidden::make('product_id'),
                Hidden::make('buying_price'),
                Hidden::make('buy_total'),
                Hidden::make('sell_total'),
                Hidden::make('profit'),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $buyingPrice = $get('buying_price') ?? 0;
                        $sellingPrice = $get('selling_price') ?? 0;

                        $set('buy_total', $state * $buyingPrice);
                        $set('profit', ($state * $sellingPrice) - ($state * $buyingPrice));
                    }),
                TextInput::make('selling_price')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        $quantity = $get('quantity') ?? 0;
                        $buyingPrice = $get('buying_price') ?? 0;
                        $set('profit', ($quantity * $state) - ($quantity * $buyingPrice));
                    }),
                DatePicker::make('sales_date')
                    ->required(),
                Textarea::make('remarks')
                    ->columnSpanFull(),
            ]);
    }
}
