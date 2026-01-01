<?php

namespace App\Livewire;

use Filament\Widgets\ChartWidget;

class MonthlySalesChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
