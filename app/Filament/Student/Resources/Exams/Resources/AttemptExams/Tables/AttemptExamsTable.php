<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttemptExamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exam.title')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->searchable(),
                TextColumn::make('correct')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('wrong')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('marks')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
