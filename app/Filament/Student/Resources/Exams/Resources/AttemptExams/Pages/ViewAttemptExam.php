<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages;

use App\Filament\Student\Resources\Exams\Resources\AttemptExams\AttemptExamResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAttemptExam extends ViewRecord
{
    protected static string $resource = AttemptExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
