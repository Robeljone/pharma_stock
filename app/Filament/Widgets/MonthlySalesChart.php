<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlySalesChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Sales Chart';
    protected int $height = 200;

    protected function getData(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::createFromDate(null, $month, 1)->format('M');
        });

        // Monthly Sales
        $sales = DB::table('sales')
            ->selectRaw('MONTH(created_at) as month, SUM(sell_total) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Monthly Profit
        $profit = DB::table('sales')
            ->selectRaw('MONTH(created_at) as month, SUM(profit) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $months->map(fn($m, $i) => $sales->get($i+1, 0)),
                    'backgroundColor' => '#1E40AF',
                ],
                [
                    'label' => 'Profit',
                    'data' => $months->map(fn($m, $i) => $profit->get($i+1, 0)),
                    'backgroundColor' => '#16A34A',
                ],
            ],
            'labels' => $months->toArray(),
        ];

    }

    protected function getType(): string
    {
        return 'bar';
    }
}
