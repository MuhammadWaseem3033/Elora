<?php

namespace App\Filament\Resources\Designs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DesignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('featured_image')
                    ->label('Image')
                    ->disk('public_uploads')
                    ->square(),

                TextColumn::make('title')
                    ->label('Design Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('designer')
                    ->searchable()
                    ->placeholder('Not specified')
                    ->toggleable(),

                TextColumn::make('collection_name')
                    ->label('Collection')
                    ->searchable()
                    ->placeholder('Not specified'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                        default => 'secondary',
                    }),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),

                TextColumn::make('published_at')
                    ->label('Published Date')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Not published')
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([

                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),

                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category'),

                SelectFilter::make('is_featured')
                    ->options([
                        1 => 'Featured',
                        0 => 'Not Featured',
                    ])
                    ->label('Featured Status'),

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
