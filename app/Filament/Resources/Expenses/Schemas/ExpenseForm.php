<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('exp_name')->label('Expense Name')
                    ->required(),
                TextInput::make('amount')->label('Amount')
                    ->required()
                    ->numeric(),
                Textarea::make('reason')->label('Reason')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('remarks')->label('Remarks')
                    ->required()
                    ->columnSpanFull(),
                DatePicker::make('date')->label('Expense Date')
                    ->required(),
            ]);
    }
}
