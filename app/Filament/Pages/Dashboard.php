<?php 

namespace App\Filament\Pages;

use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Resources\MyResource\Widgets\ProductsChart;
use App\Filament\Resources\MyResource\Widgets\UsersChart;
use App\Filament\Resources\MyResource\Widgets\StatsOverview;

class Dashboard extends \Filament\Pages\Dashboard
{

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            StatsOverview::class,
            ProductsChart::class,
            UsersChart::class,
        ];
    }
    
}

?>