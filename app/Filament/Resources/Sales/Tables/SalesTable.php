<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('buying_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('selling_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('buy_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sell_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('profit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sales_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
