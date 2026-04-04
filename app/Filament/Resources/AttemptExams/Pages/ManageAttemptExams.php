<?php

namespace App\Filament\Resources\AttemptExams\Pages;

use App\Filament\Resources\AttemptExams\AttemptExamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAttemptExams extends ManageRecords
{
    protected static string $resource = AttemptExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
