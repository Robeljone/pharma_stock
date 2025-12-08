<?php

namespace App\Filament\Resources\Purchases\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\JsContent;
use App\Models\Product;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                ->label('Product')
                ->options(Product::query()->pluck('name', 'id'))
                ->searchable(),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->required()
                    ->numeric()
                    ->afterStateUpdatedJs(<<<'JS'
        $set('total', ($get('quantity') ?? 0) * ($get('buying_price') ?? 0));
        JS),
                TextInput::make('buying_price')
                    ->label('Buying Price')
                    ->required()
                    ->numeric()
                    ->prefix('$')
                    ->afterStateUpdatedJs(<<<'JS'
        $set('total', ($get('quantity') ?? 0) * ($get('buying_price') ?? 0));
        JS),
                Select::make('unit')
                    ->options([
                        'bottle' => 'Bottle',
                        'strip' => 'Strip',
                        'pk' => 'PK',
                    ]),
                DatePicker::make('exp_date'),
                TextInput::make('total')
    ->label('Total')
    ->numeric()
    ->disabled()     // read-only for user
    ->default(0)
    ->dehydrated(),
                Textarea::make('remarks')
                    ->columnSpanFull()
            ]);
    }
}
