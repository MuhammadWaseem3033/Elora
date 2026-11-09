<?php

namespace App\Filament\Resources\Designs\Schemas;

use App\Models\Category;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DesignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Design Information')
                    ->description('Basic information about the fashion design.')
                    ->schema([

                        Select::make('category_id')
                            ->label('Category')
                            ->options(fn() => Category::where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('title')
                            ->label('Design Title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Set $set, ?string $state) =>
                                $set('slug', Str::slug($state ?? ''))
                            ),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('short_description')
                            ->label('Short Description')
                            ->rows(3)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Full Description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Design Details')
                    ->schema([

                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public_uploads')
                            ->directory('images/designs')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->required(),

                        TextInput::make('designer')
                            ->label('Designer Name')
                            ->maxLength(255),

                        TextInput::make('collection_name')
                            ->label('Collection Name')
                            ->maxLength(255),

                    ])
                    ->columns(2),

                Section::make('Publishing & SEO')
                    ->schema([

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->default('draft')
                            ->required(),

                        Toggle::make('is_featured')
                            ->label('Featured Design')
                            ->default(false),

                        DateTimePicker::make('published_at')
                            ->label('Publication Date'),

                        TextInput::make('sort_order')
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

                    ])
                    ->columns(2),
                Section::make('Design Gallery')
                    ->description('Upload multiple images for this fashion design.')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->label('Gallery Images')
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public_uploads')
                                    ->directory('images/designs/gallery')
                                    ->visibility('public')
                                    ->maxSize(4096)
                                    ->required(),

                                TextInput::make('alt_text')
                                    ->label('Image Alt Text')
                                    ->maxLength(255),

                                TextInput::make('sort_order')
                                    ->label('Display Order')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),

                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add Design Image')
                            ->reorderable()
                            ->collapsible()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

            ]);
    }
}
