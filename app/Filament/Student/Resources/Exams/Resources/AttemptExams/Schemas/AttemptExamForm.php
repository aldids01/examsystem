<?php

namespace App\Filament\Student\Resources\Exams\Resources\AttemptExams\Schemas;


use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AttemptExamForm
{


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(function ($livewire) {
                $exam = $livewire->parentRecord;

                $questions = $exam
                    ->questions()
                    ->with('options')
                    ->get();

                return [

                    View::make('filament.components.exam-timer')
                        ->viewData([
                            'time' => ($exam->time ?? 10) * 60, // convert minutes to seconds
                        ]),

                    Wizard::make(
                        $questions->map(function ($question, $index) {

                            return Step::make('Question ' . ($index + 1))
                                ->hiddenLabel()
                                ->completedIcon(Heroicon::HandThumbUp)
                                ->schema([
                                    Radio::make("answers.{$question->id}")
                                        ->label($question->question)
                                        ->options(
                                            $question->options
                                                ->pluck('option', 'id')
                                                ->toArray()
                                        )
                                        ->required(),
                                ]);
                        })->values()->all()
                    )
                        ->statePath('answers')
                        ->submitAction(
                            Action::make('submitQuiz')
                                ->label('Submit Quiz')
                                ->icon('heroicon-s-hand-thumb-up')
                                ->color('primary')
                                ->requiresConfirmation()
                                ->modalHeading('Submit Quiz')
                                ->modalDescription('Are you sure you want to submit this quiz? You will not be able to change your answers.')
                                ->modalSubmitActionLabel('Yes, Submit')
                                ->action('submitExam')
                        )
                ];
            })->columns(1);
    }


}
