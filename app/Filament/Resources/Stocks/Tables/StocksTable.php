<?php

namespace App\Filament\Resources\Stocks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StocksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Product.name')
                    ->label('Product')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('available_stock')
                    ->label('Available')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('Purchase.buying_price')
                    ->label('Buying Price')
                    ->numeric()
                    ->money()
                    ->sortable(),
                TextColumn::make('Purchase.exp_date')
                    ->label('Expire Date')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('Purchase.created_at')
                    ->label('Purchase Date')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
