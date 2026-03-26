<?php

namespace App\Filament\Student\Pages;

use App\Filament\Student\Resources\Exams\Widgets\ResultOverview;
use App\Models\AttemptExam;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class Result extends Page implements HasTable
{
    use InteractsWithTable;
    protected string $view = 'filament.student.pages.result';

    public function getHeading(): string|Htmlable|null
    {
        return auth('student')->user()->name . ' Results';
    }

    protected static ?int $navigationSort =3;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedPrinter;

    public function table(Table $table): Table
    {
        return $table
            ->query(AttemptExam::query()->where('student_id', auth('student')->id()))
            ->columns([
                TextColumn::make('exam.title')
                    ->searchable(),
                TextColumn::make('exam.course.title')
                    ->searchable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grade')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grade_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('credit_unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('credit_point')
                    ->numeric()
                    ->sortable(),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
          ResultOverview::class,
        ];
    }
}
