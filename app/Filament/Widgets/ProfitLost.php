<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ProfitLost extends ChartWidget
{
    protected ?string $heading = 'Profit Lost';
    protected function getFilters(): ?array
    {
        return collect(range(1, 12))->mapWithKeys(function ($month) {
            return [
                $month => Carbon::create()->month($month)->format('F'),
            ];
        })->toArray();
    }

    /**
     * Chart data using SAMPLE values
     */
    protected function getData(): array
    {
        $month = $this->filter ?? now()->month;

        // 🔹 Sample monthly data (Revenue & Cost)
        $sampleData = [
            1  => ['revenue' => 120000, 'cost' => 80000],
            2  => ['revenue' => 150000, 'cost' => 90000],
            3  => ['revenue' => 180000, 'cost' => 110000],
            4  => ['revenue' => 140000, 'cost' => 100000],
            5  => ['revenue' => 200000, 'cost' => 130000],
            6  => ['revenue' => 220000, 'cost' => 150000],
            7  => ['revenue' => 170000, 'cost' => 120000],
            8  => ['revenue' => 160000, 'cost' => 115000],
            9  => ['revenue' => 210000, 'cost' => 140000],
            10 => ['revenue' => 230000, 'cost' => 160000],
            11 => ['revenue' => 190000, 'cost' => 125000],
            12 => ['revenue' => 250000, 'cost' => 170000],
        ];

        $revenue = $sampleData[$month]['revenue'];
        $cost    = $sampleData[$month]['cost'];
        $profit  = $revenue - $cost;

        return [
            'datasets' => [
                [
                    'data' => [
                        max($profit, 0),
                        max($cost, 0),
                    ],
                ],
            ],
            'labels' => ['Profit', 'Loss'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected int | string | array $columnSpan = 1;

}
