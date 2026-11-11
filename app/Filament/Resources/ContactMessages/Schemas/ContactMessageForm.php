<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Visitor Information')
                ->schema([

                    TextInput::make('name')
                        ->label('Visitor Name')
                        ->disabled()
                        ->dehydrated(false),

                    TextInput::make('email')
                        ->label('Email Address')
                        ->disabled()
                        ->dehydrated(false),

                    TextInput::make('subject')
                        ->label('Subject')
                        ->disabled()
                        ->dehydrated(false),

                    Textarea::make('message')
                        ->label('Visitor Message')
                        ->disabled()
                        ->dehydrated(false)
                        ->rows(8)
                        ->columnSpanFull(),

                ])->columns(2),

            Section::make('Message Management')
                ->schema([

                    Toggle::make('is_read')
                        ->label('Mark as Read')
                        ->default(false),

                ]),

        ]);
    }
}
