<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Purchase;

class SalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                ->label('Product (Name | Buying Price | Stock)')
                ->options(function () {
        return Purchase::with('product') // eager load product if needed
            ->get()
            ->pluck(
                fn($purchase) => $purchase->product->name . ' - ' . number_format($purchase->buying_price, 2).'Birr',
                'id' // purchase id as the value
            );
    })
                ->searchable(),
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
