<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MtdSalesProfitChart extends ChartWidget
{
    protected ?string $heading = 'Mtd Sales Profit Chart';
    protected function getData(): array
    {
    $year = now()->year;

        // Labels: Jan to Dec
        $months = collect(range(1, 12))->map(fn($month) => Carbon::createFromDate($year, $month, 1)->format('M'))->toArray();

        $salesData = [];

        foreach (range(1, 12) as $month) {
            // Sum sales from start of month to today if current month, else full month
            $start = Carbon::create($year, $month, 1)->startOfMonth();
            $end = ($month === now()->month) ? now()->endOfDay() : Carbon::create($year, $month, 1)->endOfMonth();

            $sales = DB::table('sales')
                ->whereBetween('sales_date', [$start, $end])
                ->sum('sell_total');

            $salesData[] = $sales;
        }

        return [
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'MTD Sales',
                    'data' => $salesData,
                    'borderColor' => '#3B82F6', // Blue
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'fill' => true,
                    'tension' => 0.4, // smooth line
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
