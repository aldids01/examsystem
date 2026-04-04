<?php

namespace App\Filament\Resources\Courses\Widgets;

use App\Models\AttemptExam;
use App\Models\Course;
use App\Models\Department;
use App\Models\Level;
use App\Models\Student;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Statistics extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('No of Tutors', User::query()->count()),
            Stat::make('Not of Students', Student::query()->count()),
            Stat::make('No of Courses', Course::query()->count()),
            Stat::make('No of Levels', Level::query()->count()),
            Stat::make('No of Departments', Department::query()->count()),
            Stat::make('Exam Attempted', AttemptExam::query()->count()),
        ];
    }
}
