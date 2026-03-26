<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Pages;

use App\Filament\Student\Pages\Result;
use App\Filament\Student\Resources\Exams\Resources\AttemptExams\AttemptExamResource;
use App\Models\AttemptExam;
use App\Models\Exam;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAttemptExam extends CreateRecord
{
    protected static string $resource = AttemptExamResource::class;

    protected ?string $heading = 'Attempt Exam';
    protected function getFormActions(): array
    {
        return [];
    }

    public static function calculate($score): array
    {
        if ($score >= 70) {
            return ['grade' => 'A', 'gp' => 5];
        }

        if ($score >= 60) {
            return ['grade' => 'B', 'gp' => 4];
        }

        if ($score >= 50) {
            return ['grade' => 'C', 'gp' => 3];
        }

        if ($score >= 45) {
            return ['grade' => 'D', 'gp' => 2];
        }

        if ($score >= 40) {
            return ['grade' => 'E', 'gp' => 1];
        }

        return ['grade' => 'F', 'gp' => 0];
    }

    public function submitExam(): void
    {
        $exam = $this->parentRecord;
        $questions = $exam->questions()->with('options')->get();
        $student = auth('student')->user();

        $answers = $this->form->getState()['answers'] ?? [];

        if (empty($answers)) {
            Notification::make()
                ->title('No answers submitted')
                ->warning()
                ->send();
            return;
        }

        if (AttemptExam::where('exam_id', $exam->id)
            ->where('student_id', $student->id)
            ->exists()
        ) {
            Notification::make()
                ->title('You have already attempted this exam')
                ->danger()
                ->send();
            return;
        }

        $score = 0;
        $totalMarks = 0;

        foreach ($questions as $question) {
            $maxMarks = $question->options->max('marks_obtained') ?? 0;
            $totalMarks += $maxMarks;
            $questionId = $question->id;

            $selectedOptionId = $answers['answers'][$questionId];


            if ($selectedOptionId) {
                $selectedOption = $question->options
                    ->firstWhere('id', (int) $selectedOptionId);

                if ($selectedOption) {
                    $score += (float) $selectedOption->marks_obtained;

                }
            }
        }

        $percentage = $totalMarks > 0
            ? round(($score / $totalMarks) * 100, 2)
            : 0;

        /*
   |--------------------------------------------------------------------------
   | Grade System Integration
   |--------------------------------------------------------------------------
   */


        if ($percentage >= 70) {
            $grade = 'A';
            $gradePoint = 5;
        } elseif ($percentage >= 60) {
            $grade = 'B';
            $gradePoint = 4;
        } elseif ($percentage >= 50) {
            $grade = 'C';
            $gradePoint = 3;
        } elseif ($percentage >= 45) {
            $grade = 'D';
            $gradePoint = 2;
        } elseif ($percentage >= 40) {
            $grade = 'E';
            $gradePoint = 1;
        } else {
            $grade = 'F';
            $gradePoint = 0;
        }

        /*
   |--------------------------------------------------------------------------
   | Credit Unit & Credit Point
   |--------------------------------------------------------------------------
   */

        $creditUnit = $exam->course->units ?? 0;

        $creditPoint = $creditUnit * $gradePoint;

        AttemptExam::create([
            'exam_id' => $exam->id,
            'student_id' => $student->id,
            'score' => $score,
            'grade' => $grade,
            'grade_point' => $gradePoint,
            'credit_unit' => $creditUnit,
            'credit_point' => $creditPoint,

            'started_at' => now(),
            'completed_at' => now(),
            'expires_at' => $exam->time ? now()->addMinutes($exam->time) : null,
        ]);

        $this->redirect(Result::getUrl());

        Notification::make()
            ->title('You have successfully attempted this quiz')
            ->success()
            ->send();
    }
}
