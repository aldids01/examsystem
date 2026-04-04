<?php

namespace App\Filament\Resources\AttemptExams;

use App\Filament\Resources\AttemptExams\Pages\ManageAttemptExams;
use App\Models\AttemptExam;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AttemptExamResource extends Resource
{
    protected static ?string $model = AttemptExam::class;
    protected static ?int $navigationSort = 500;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('exam_id')
                    ->relationship('exam', 'title')
                    ->required(),
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required(),
                TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('grade'),
                TextInput::make('grade_point')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('credit_unit')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('credit_point')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('completed_at'),
                DateTimePicker::make('expires_at'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('exam.title')
                    ->label('Exam'),
                TextEntry::make('student.name')
                    ->label('Student'),
                TextEntry::make('score')
                    ->numeric(),
                TextEntry::make('grade')
                    ->placeholder('-'),
                TextEntry::make('grade_point')
                    ->numeric(),
                TextEntry::make('credit_unit')
                    ->numeric(),
                TextEntry::make('credit_point')
                    ->numeric(),
                TextEntry::make('started_at')
                    ->dateTime(),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('expires_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exam.title')
                    ->searchable(),
                TextColumn::make('student.name')
                    ->searchable(),
                TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grade')
                    ->searchable(),
                TextColumn::make('grade_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('credit_unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('credit_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->dateTime('F j, Y g:i a')
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->dateTime('F j, Y g:i a')
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime('F j, Y g:i a')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('F j, Y g:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('F j, Y g:i a')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAttemptExams::route('/'),
        ];
    }
}
