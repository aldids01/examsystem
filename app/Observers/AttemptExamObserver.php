<?php

namespace App\Observers;

use App\Models\AttemptExam;
use Filament\Notifications\Notification;

class AttemptExamObserver
{
    /**
     * Handle the AttemptExam "created" event.
     */
    public function created(AttemptExam $attemptExam): void
    {
        $student = auth('student')->user();

        if ($attemptExam->where('student_id', $student->id)->exists()) {
            Notification::make()
                ->title('You have already attempted this exam')
                ->danger()
                ->send();
            return;
        }

        $questions = $attemptExam
            ->questions()
            ->with('options')
            ->get();

        $score = 0;
        $totalMarks = 0;
        $correct = 0;
        $wrong = 0;

        foreach ($questions as $question) {

            $maxMarksForQuestion = $question->options->max('marksObtainable') ?? 0;
            $totalMarks += $maxMarksForQuestion;

            $selectedOptionId = $data['answers'][$question->id] ?? null;

            if ($selectedOptionId) {
                $selectedOption = $question->options
                    ->firstWhere('id', (int) $selectedOptionId);

                if ($selectedOption) {
                    $score += (float) $selectedOption->marksObtainable;

                    if ($selectedOption->is_correct) {
                        $correct++;
                    } else {
                        $wrong++;
                    }
                }
            }
        }

        $percentage = $totalMarks > 0
            ? round(($score / $totalMarks) * 100, 2)
            : 0;

        $startedAt = now();
        $expiresAt = $attemptExam->time
            ? $startedAt->copy()->addMinutes($attemptExam->time)
            : null;

        $attemptExam->create([
            'student_id'   => $student->id,
            'correct'      => $correct,
            'wrong'        => $wrong,
            'score'        => $score,
            'total'        => $wrong + $correct,
            'marks'        => $totalMarks,
            'percentage'   => $percentage,
            'started_at'   => $startedAt,
            'completed_at' => now(),
            'expires_at'   => $expiresAt,
        ]);

        Notification::make()
            ->title('You have successfully attempted this quiz')
            ->success()
            ->send();
    }

    /**
     * Handle the AttemptExam "updated" event.
     */
    public function updated(AttemptExam $attemptExam): void
    {
        //
    }

    /**
     * Handle the AttemptExam "deleted" event.
     */
    public function deleted(AttemptExam $attemptExam): void
    {
        //
    }

    /**
     * Handle the AttemptExam "restored" event.
     */
    public function restored(AttemptExam $attemptExam): void
    {
        //
    }

    /**
     * Handle the AttemptExam "force deleted" event.
     */
    public function forceDeleted(AttemptExam $attemptExam): void
    {
        //
    }
}
