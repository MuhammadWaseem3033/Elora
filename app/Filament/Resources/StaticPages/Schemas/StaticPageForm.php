<?php

namespace App\Filament\Resources\StaticPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StaticPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Page Information')
                ->description('Manage your website static page content.')
                ->schema([

                    TextInput::make('title')
                        ->label('Page Title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(
                            fn (Set $set, ?string $state) =>
                                $set('slug', Str::slug($state ?? ''))
                        ),

                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    RichEditor::make('content')
                        ->label('Page Content')
                        ->columnSpanFull(),

                ])->columns(2),

            Section::make('Page Media')
                ->schema([

                    FileUpload::make('featured_image')
                        ->label('Featured Image')
                        ->image()
                        ->disk('public_uploads')
                        ->directory('images/pages')
                        ->visibility('public')
                        ->maxSize(4096),

                ]),

            Section::make('Publishing & SEO')
                ->schema([

                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                        ])
                        ->default('draft')
                        ->required(),

                    TextInput::make('sort_order')
                        ->label('Display Order')
                        ->numeric()
                        ->default(0)
                        ->required(),

                    TextInput::make('meta_title')
                        ->label('SEO Title')
                        ->maxLength(255),

                    Textarea::make('meta_description')
                        ->label('SEO Description')
                        ->rows(3)
                        ->columnSpanFull(),

                ])->columns(2),

        ]);
    }
}
