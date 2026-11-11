<?php

namespace App\Filament\Resources\NewsletterSubscribers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterSubscriberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Subscriber Information')
                ->schema([

                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Toggle::make('is_active')
                        ->label('Active Subscriber')
                        ->default(true),

                ])->columns(2),

        ]);
    }
}
