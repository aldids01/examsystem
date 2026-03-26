<?php

namespace App\Filament\Student\Pages\Auth;

use Filament\Auth\Pages\EditProfile;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudentProfile extends EditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->revealable()
                    ->password()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('mobile'),
                Textarea::make('address')
                    ->columnSpanFull(),
            ]);
    }
}
