<?php

namespace App\Filament\Resources\Advertisements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdvertisementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Advertisement Information')
                ->schema([

                    TextInput::make('title')
                        ->label('Advertisement Title')
                        ->required()
                        ->maxLength(255),

                    Select::make('placement')
                        ->label('Advertisement Placement')
                        ->options([
                            'header' => 'Header',
                            'sidebar' => 'Sidebar',
                            'in_article' => 'In Article',
                            'between_designs' => 'Between Designs',
                            'footer' => 'Footer',
                        ])
                        ->required(),

                    Textarea::make('ad_code')
                        ->label('Advertisement Code')
                        ->rows(8)
                        ->columnSpanFull(),

                    Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),

                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->required(),

                ])->columns(2),

            Section::make('Advertisement Schedule')
                ->schema([

                    DateTimePicker::make('start_date')
                        ->label('Start Date'),

                    DateTimePicker::make('end_date')
                        ->label('End Date'),

                ])->columns(2),

        ]);
    }
}
