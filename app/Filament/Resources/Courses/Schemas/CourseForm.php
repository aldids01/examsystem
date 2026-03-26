<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Course')
                        ->schema([
                            TextInput::make('code')
                                ->required(),
                            TextInput::make('title')
                                ->required(),
                            Textarea::make('description')
                                ->rows(10)
                                ->columnSpanFull(),
                            Grid::make(4)
                                ->schema([
                                    TextInput::make('units')
                                        ->numeric(),
                                    Select::make('level_id')
                                        ->relationship('level', 'name')
                                        ->createOptionForm([
                                            TextInput::make('name')->required(),
                                            Select::make('user_id')
                                                ->relationship('user', 'name')
                                                ->default(fn()=> auth()->user()->id)
                                                ->required(),
                                        ])
                                        ->createOptionModalHeading('New course level')
                                        ->required(),
                                    Select::make('user_id')
                                        ->relationship('user', 'name')
                                        ->default(fn()=> auth()->user()->id)
                                        ->required(),
                                    Select::make('department_id')
                                        ->relationship('department', 'name')
                                        ->required(),
                                ])->columnSpanFull()
                        ])->columns(2),
                    Step::make('Exams')
                        ->schema([
                            Repeater::make('exam')
                                ->hiddenLabel()
                                ->deletable(false)
                                ->addable(false)
                                ->relationship('exam')
                                ->columnSpanFull()
                                ->schema([
                                    TextInput::make('title')
                                        ->required(),
                                    TextInput::make('time')
                                        ->suffix('Minutes')
                                        ->numeric()
                                        ->required(),
                                    Repeater::make('question')
                                        ->hiddenLabel()
                                        ->collapsed()
                                        ->columnSpanFull()
                                        ->relationship('questions')
                                        ->schema([
                                            Textarea::make('question')
                                                ->required(),
                                            Repeater::make('option')
                                                ->hiddenLabel()
                                                ->grid(2)
                                                ->compact()
                                                ->collapsed()
                                                ->columnSpanFull()
                                                ->relationship('options')
                                                ->schema([
                                                    TextInput::make('option')
                                                        ->required(),
                                                    ToggleButtons::make('is_correct')
                                                        ->live()
                                                        ->inline()
                                                        ->options([
                                                            true => 'Yes',
                                                            false => 'No',
                                                        ])->default(false),
                                                    TextInput::make('marks_obtained')
                                                        ->visible(fn(Get $get) => $get('is_correct')==true),
                                                ])->columns(2)->itemLabel(fn (array $state): ?string => $state['option'] ?? 'Options')
                                        ])->itemLabel(fn (array $state): ?string => $state['question'] ?? 'Questions')
                                ])->columns(2)->compact()
                        ]),
                ])->columnSpanFull(),
            ])->columns(2);
    }
}
