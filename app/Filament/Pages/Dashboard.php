<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\EloraStatsOverview;
use Filament\Pages\Page;
use Override;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';
    // protected static ?string $title = 'ÉLORA Dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            EloraStatsOverview::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 4,
        ];
    }
}
