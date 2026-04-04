<?php

namespace App\Filament\Student\Resources\Exams;

use App\Filament\Student\Pages\Result;
use App\Filament\Student\Resources\Exams\Pages\AttemptExam;
use App\Filament\Student\Resources\Exams\Pages\ManageExams;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\AttemptExamResource;
use App\Models\Exam;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExamResource extends Resource
{
    protected static ?string $model = Exam::class;
    protected static ?int $navigationSort =2;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'title';


    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
               Stack::make([
                   TextColumn::make('title')
                    ->weight(FontWeight::ExtraBold)
                    ->size(TextSize::Large),
                   TextColumn::make('course.title')
                        ->prefix('Course title: '),
                   TextColumn::make('time')
                       ->prefix('Time allowed: ')
                       ->suffix(' minutes')
                       ->numeric(),
               ])
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->recordActions([
                Action::make('result')
                    ->label('View Results')
                    ->disabled(fn($record) => \App\Models\AttemptExam::where('exam_id', $record->id)->doesntExist())
                    ->url(fn($record) => Result::getUrl()),
                Action::make('start')
                    ->label('Start Exam')
                    ->disabled(fn($record) => \App\Models\AttemptExam::where('exam_id', $record->id)->exists())
                    ->url(fn($record) => AttemptExamResource::getUrl('create', ['exam' => $record]))
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageExams::route('/'),
            'create' => AttemptExam::route('/{record}/create'),
            'attempt' => AttemptExam::route('/{record}/attempt'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])->whereHas('course', function (Builder $query) {
                $query->where('department_id', auth('student')->user()->department_id);
            });
    }
}
