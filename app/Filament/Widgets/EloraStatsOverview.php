<?php

namespace App\Filament\Widgets;

use App\Models\Design;
use App\Models\Category;
use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EloraStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Designs', number_format(Design::count()))
                ->description('Fashion designs in collection')
                ->descriptionIcon('heroicon-m-swatch')
                ->icon('heroicon-o-swatch')
                ->color('warning'),

            Stat::make('Total Design Views', number_format(Design::sum('views')))
                ->description('Total unique session views')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-eye')
                ->color('success'),

            Stat::make('Journal Articles', number_format(Article::count()))
                ->description('Published and draft articles')
                ->descriptionIcon('heroicon-m-newspaper')
                ->icon('heroicon-o-newspaper')
                ->color('info'),

            Stat::make('Total Categories', number_format(Category::count()))
                ->description('Fashion categories')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->icon('heroicon-o-rectangle-stack')
                ->color('danger'),
        ];
    }
}
