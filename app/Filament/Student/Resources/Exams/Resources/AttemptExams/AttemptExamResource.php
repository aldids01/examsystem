<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams;

use App\Filament\Student\Resources\Exams\ExamResource;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages\CreateAttemptExam;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages\EditAttemptExam;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages\ViewAttemptExam;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Schemas\AttemptExamForm;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Schemas\AttemptExamInfolist;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\Tables\AttemptExamsTable;
use App\Models\AttemptExam;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttemptExamResource extends Resource
{
    protected static ?string $model = AttemptExam::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ExamResource::class;

    public static function form(Schema $schema): Schema
    {
        return AttemptExamForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AttemptExamInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttemptExamsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateAttemptExam::route('/create'),
            'view' => ViewAttemptExam::route('/{record}'),
            'edit' => EditAttemptExam::route('/{record}/edit'),
        ];
    }
}
