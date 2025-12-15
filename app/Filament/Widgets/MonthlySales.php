<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MonthlySales extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => [120, 150, 300, 250, 400, 380],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
