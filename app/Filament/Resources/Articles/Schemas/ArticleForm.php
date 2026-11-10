<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Article Information')
                    ->description('Basic information about your editorial article.')
                    ->schema([

                        Select::make('blog_category_id')
                            ->label('Blog Category')
                            ->relationship('blogCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('title')
                            ->label('Article Title')
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

                        Textarea::make('excerpt')
                            ->label('Short Excerpt')
                            ->rows(3)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('content')
                            ->label('Article Content')
                            ->columnSpanFull(),

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
                            ->label('Featured Article')
                            ->default(false),

                        DateTimePicker::make('published_at')
                            ->label('Publication Date'),

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

                    ])
                    ->columns(2),

                Section::make('Article Media & Author')
                    ->schema([

                        FileUpload::make('featured_image')
                            ->label('Featured Image')
                            ->image()
                            ->disk('public_uploads')
                            ->directory('images/articles')
                            ->visibility('public')
                            ->maxSize(4096),

                        TextInput::make('author')
                            ->label('Author Name')
                            ->maxLength(255),

                    ])
                    ->columns(2),

                Section::make('Related Fashion Designs')
                    ->description('Select fashion designs related to this article.')
                    ->schema([

                        Select::make('designs')
                            ->label('Related Designs')
                            ->relationship(
                                name: 'designs',
                                titleAttribute: 'title'
                            )
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ]),
            ]);
    }
}
