<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Course;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('units')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('level.name')
                    ->label('Level'),
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Course $record): bool => $record->trashed()),
            ]);
    }
}
