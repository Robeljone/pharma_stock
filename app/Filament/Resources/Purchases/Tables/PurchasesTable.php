<?php

namespace App\Filament\Resources\Purchases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PurchasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Product')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('buying_price')
                    ->label('Buying Price')
                    ->money()
                    ->sortable(),
                TextColumn::make('unit')
                    ->label('Unit')
                    ->searchable(),
                TextColumn::make('exp_date')
                    ->label('Expire Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->numeric()
                    ->sortable(),
            ])

            ->filters([
            Filter::make('expire_date')
                ->label('Near Expiry (15 days)')
                ->toggle()
                 ->default(
                        fn (): bool => (bool) request()->input('tableFilters.is_active.is_active', false)
                )
                ->query(fn (Builder $query) =>
                    $query->whereDate('exp_date', '<=', now()->addDays(15))
                ),
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
