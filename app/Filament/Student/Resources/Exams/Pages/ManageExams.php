<?php

namespace App\Filament\Student\Resources\Exams\Pages;

use App\Filament\Student\Resources\Exams\ExamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageExams extends ManageRecords
{
    protected static string $resource = ExamResource::class;

}
