<?php

namespace App\Filament\Student\Resources\Exams\Pages;

use App\Filament\Student\Resources\Exams\ExamResource;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\AttemptExamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Table;

class AttemptExam extends ManageRelatedRecords
{
    protected static string $resource = ExamResource::class;

    protected static string $relationship = 'attempts';

    protected static ?string $relatedResource = AttemptExamResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
