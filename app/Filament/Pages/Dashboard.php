<?php 

namespace App\Filament\Pages;

use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Resources\MyResource\Widgets\ProductsChart;
use App\Filament\Resources\MyResource\Widgets\CustomersChart;

class Dashboard extends \Filament\Pages\Dashboard
{

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            ProductsChart::class,
            CustomersChart::class,
        ];
    }
    
}

?>