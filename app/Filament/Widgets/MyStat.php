<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class MyStat extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
           $today = now()->toDateString();

    // Daily sales & profit
    $daily = DB::table('products')
        ->join('sales', 'sales.product_id', '=', 'products.id')
        ->whereDate('sales.created_at', $today)
        ->selectRaw('
            SUM(sales.sell_total) as total_sales,
            SUM(sales.profit) as total_profit
        ')
        ->first();

    // Low stock
    $lowStock = DB::table('stocks')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->whereColumn('stocks.available_stock', '<=','products.reorder_level')
        ->count();

    $expire_date = DB::table('products')
        ->join('purchases', 'purchases.product_id', '=', 'products.id')
        ->whereDate('purchases.exp_date', '<=', now()->addDays(15))
        ->count();

        return [
            Stat::make('Daily Sales Total', number_format($daily->total_sales ?? 0) . ' Birr')
            ->icon('heroicon-o-banknotes')
            ->color('success'),
            Stat::make('Daily Sales Profit', number_format($daily->total_profit ?? 0) . ' Birr')
            ->icon('heroicon-o-arrow-trending-up')
            ->color('success'),
             Stat::make('Low Stock', $lowStock . ' Items')
            ->icon('heroicon-o-exclamation-triangle')
            ->color($lowStock > 0 ? 'danger' : 'success')
             ->url(
               route('filament.stock.resources.stocks.index', [
                'tableFilters' => [
                    'low_stock' => [
                        'is_active' => true,
                    ],
                ],
            ])
            )
            ,
            Stat::make('Nearly Expire Medicine', $expire_date . ' Items')
            ->icon('heroicon-o-clock')
            ->color($expire_date > 0 ? 'warning' : 'success')
            ->url(
               route('filament.stock.resources.purchases.index', [
                'tableFilters' => [
                    'expire_date' => [
                        'is_active' => true,
                    ],
                ],
            ])
            )
        ];
    }
}
