<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';
    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\MyStat::class,
            \App\Filament\Widgets\MonthlySalesChart::class,
            \App\Filament\Widgets\MtdSalesProfitChart::class,
        ];
    }
}
