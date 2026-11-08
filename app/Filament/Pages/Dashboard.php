<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    // protected string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'ÉLORA Dashboard';

    public function getColumns(): int | array
    {
        return [
            'md' => 2,
            'xl' => 4,
        ];
    }
}
