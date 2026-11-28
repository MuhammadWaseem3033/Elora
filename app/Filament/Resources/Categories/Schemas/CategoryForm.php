<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->description('Add fashion category details for ÉLORA.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(Set $set, ?string $state) =>
                                $set('slug', Str::slug($state))
                            ),
                        TextInput::make('slug')
                            ->label('Category Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        FileUpload::make('image')
                            ->label('Category Image')
                            ->image()
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                            ])
                            ->maxSize(3048)
                            ->disk('public_uploads')
                            ->directory('images/categories')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth('1200')
                            ->imageResizeTargetHeight('1200')
                            ->imagePreviewHeight('150')
                            ->saveUploadedFileUsing(function (TemporaryUploadedFile $file): string {

                                $image = (new ImageManager(new Driver()))
                                    ->read($file->getRealPath());

                                $image->scaleDown(1200, 1200);

                                $filename = Str::uuid() . '.webp';

                                $path = 'images/categories/' . $filename;

                                $encoded = $image->toWebp(80);

                                $saved = Storage::disk('public_uploads')
                                    ->put($path, (string) $encoded);

                                if (! $saved) {
                                    throw new \RuntimeException('Unable to save optimized image.');
                                }

                                return $path;
                            })
                            ->required(),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true),

                        TextInput::make('sort_order')
                            ->label('Display Order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),
                // SEO Information
                Section::make('SEO Information')
                    ->description('Optimize this category for search engines and image accessibility.')
                    ->schema([

                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Enter SEO-friendly category title')
                            ->maxLength(255)
                            ->helperText('Recommended length: 50–60 characters.')
                            ->columnSpanFull(),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Enter SEO-friendly category description')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Recommended length: 140–160 characters.')
                            ->columnSpanFull(),

                        TextInput::make('image_alt')
                            ->label('Image Alt Text')
                            ->placeholder('Describe the category image')
                            ->maxLength(255)
                            ->helperText('Write a natural description of the category image.')
                            ->columnSpanFull(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
