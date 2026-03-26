<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AttemptExamInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('exam.title')
                    ->label('Exam'),
                TextEntry::make('student.name')
                    ->label('Student'),
                TextEntry::make('correct')
                    ->numeric(),
                TextEntry::make('wrong')
                    ->numeric(),
                TextEntry::make('score')
                    ->numeric(),
                TextEntry::make('total')
                    ->numeric(),
                TextEntry::make('marks')
                    ->numeric(),
                TextEntry::make('percentage')
                    ->numeric(),
                TextEntry::make('started_at')
                    ->dateTime(),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
