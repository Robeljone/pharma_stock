<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class TopSellingProductsChart extends ChartWidget
{
    protected ?string $heading = 'Top Selling Products Chart';

    protected function getData(): array
    {
        $topProducts = DB::table('sales')
            ->join('products', 'products.id', '=', 'sales.product_id')
            ->select('products.name', DB::raw('SUM(sales.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $labels = $topProducts->pluck('name')->toArray();
        $data = $topProducts->pluck('total_sold')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Quantity Sold',
                    'data' => $data,
                    'backgroundColor' => '#3B82F6', // Blue color
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
