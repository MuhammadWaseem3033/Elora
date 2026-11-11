<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Visitor Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('subject')
                    ->limit(35)
                    ->searchable(),

                TextColumn::make('message')
                    ->limit(50)
                    ->wrap(),

                TextColumn::make('is_read')
                    ->label('Message Status')
                    ->badge()
                    ->formatStateUsing(
                        fn (bool $state): string => $state ? 'Read' : 'Unread'
                    )
                    ->color(
                        fn (bool $state): string => $state ? 'success' : 'warning'
                    ),

                TextColumn::make('created_at')
                    ->label('Received Date')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),

            ])
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Message Status')
                    ->trueLabel('Read Messages')
                    ->falseLabel('Unread Messages')
                    ->placeholder('All Messages'),
            ])
            ->recordClasses(
                fn (ContactMessage $record) =>
                    $record->is_read ? null : 'bg-warning-50 dark:bg-warning-950'
            )
            ->recordActions([
                EditAction::make()
                    ->label('View / Manage'),
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
