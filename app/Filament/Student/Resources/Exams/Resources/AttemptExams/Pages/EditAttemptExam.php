<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages;

use App\Filament\Student\Resources\Exams\Resources\AttemptExams\AttemptExamResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAttemptExam extends EditRecord
{
    protected static string $resource = AttemptExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
