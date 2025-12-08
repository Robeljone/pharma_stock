<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exp_name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                              Filter::make('date')
    ->form([
        DatePicker::make('created_from')->label('From'),
        DatePicker::make('created_until')->label('To'),
    ])
    ->query(function ($query, array $data) {
        return $query
            ->when($data['created_from'], fn($q) => $q->whereDate('date', '>=', $data['created_from']))
            ->when($data['created_until'], fn($q) => $q->whereDate('date', '<=', $data['created_until']));
    }),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
