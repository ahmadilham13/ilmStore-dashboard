<?php

namespace App\Filament\Resources\MyResource\Widgets;

use App\Models\Product;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Products';

    protected function getData(): array
    {
        $data = Trend::model(Product::class)
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

    return [
        'datasets' => [
            [
                'label'     => 'Products',
                'data'      => $data->map(fn (TrendValue $value) => $value->aggregate),
            ],
        ],
        'labels'   => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
