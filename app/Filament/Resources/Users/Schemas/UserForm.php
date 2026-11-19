<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->minLength(8)
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Select::make('role')
                    ->label('Peran')
                    ->options(['admin' => 'Admin', 'operator' => 'Operator'])
                    ->required()
                    ->default('operator')
                    ->disabled(fn (): bool => ! auth()->user()?->isAdmin()),
                Toggle::make('is_active')
                    ->label('Aktif dapat login')
                    ->default(true)
                    ->disabled(fn (): bool => ! auth()->user()?->isAdmin()),
            ]);
    }
}
