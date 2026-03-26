<?php

namespace App\Filament\Student\Pages\Auth;

use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class StudentLogin extends Login
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('slug')
                    ->label('Email/Matric Number')
                    ->required(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }

    public function getHeading(): string|Htmlable|null
    {
        return 'Student Login';
    }

    public function getTitle(): string|Htmlable
    {
        return 'Student Login';
    }
    protected function getCredentialsFromFormData(array $data): array
    {
        // Determine if the input is an email address
        $loginField = filter_var($data['slug'], FILTER_VALIDATE_EMAIL) ? 'email' : 'slug';

        return [
            $loginField => $data['slug'],
            'password' => $data['password'],
        ];
    }
}
