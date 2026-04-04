<?php

namespace App\Filament\Student\Resources\Exams\Widgets;

use App\Models\AttemptExam;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ResultOverview extends StatsOverviewWidget
{
    public static function calculateGPA($studentId, $semesterId): float|int
    {
        $results = AttemptExam::query()->where('student_id', $studentId)
            ->where('semester_id', $semesterId)
            ->get();

        $totalCU = $results->sum('credit_unit');

        $totalCP = $results->sum('credit_point');

        if ($totalCU == 0) {
            return 0;
        }

        return round($totalCP / $totalCU, 2);
    }

    public static function calculateCGPA($studentId): float|int
    {
        $results = AttemptExam::query()->where('student_id', $studentId)->get();

        $totalCU = $results->sum('credit_unit');

        $totalCP = $results->sum('credit_point');

        if ($totalCU == 0) {
            return 0;
        }

        return round($totalCP / $totalCU, 3);
    }

    public static function carryOverCourses($studentId)
    {
        return AttemptExam::where('student_id', $studentId)
            ->where('grade', 'F')
            ->with('exam.course')
            ->get();
    }

    public static function degreeClass($cgpa): string
    {
        if ($cgpa >= 4.50) {
            return "First Class";
        }

        if ($cgpa >= 3.50) {
            return "Second Class Upper";
        }

        if ($cgpa >= 2.40) {
            return "Second Class Lower";
        }

        if ($cgpa >= 1.50) {
            return "Third Class";
        }

        if ($cgpa >= 1.00) {
            return "Pass";
        }

        return "Fail";
    }
    protected function getStats(): array
    {
        $student = auth('student')->user();

        $cgpa = self::calculateCGPA($student->id);

        $carryovers = self::carryOverCourses($student->id);

        $class = self::degreeClass($cgpa);

        return [
            Stat::make('CGPA', $cgpa),

            Stat::make('Degree Class', $class),

            Stat::make('Carryovers', $carryovers->count()),
        ];
    }
}
