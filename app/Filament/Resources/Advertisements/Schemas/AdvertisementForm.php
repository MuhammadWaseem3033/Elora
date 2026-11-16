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
                            'home_top' => 'Homepage - Top',
                            'home_bottom' => 'Homepage - Bottom',

                            'category_top' => 'Category - Top',
                            'category_bottom' => 'Category - Bottom',

                            'design_detail_top' => 'Design Detail - Top',
                            'design_detail_bottom' => 'Design Detail - Bottom',

                            'journal_top' => 'Journal - Top',
                            'journal_bottom' => 'Journal - Bottom',

                            'journal_detail_top' => 'Journal Detail - Top',
                            'journal_detail_bottom' => 'Journal Detail - Bottom',
                        ])
                        ->searchable()
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
                        ->label('Start Date')
                        ->seconds(false),

                    DateTimePicker::make('end_date')
                        ->label('End Date')
                        ->seconds(false)
                        ->after('start_date'),

                ])->columns(2),

        ]);
    }
}
