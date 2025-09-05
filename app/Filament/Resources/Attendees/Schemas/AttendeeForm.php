<?php

namespace App\Filament\Resources\Attendees\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AttendeeForm
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
                TextInput::make('ticket_cost')
                    ->required()
                    ->numeric(),
                Toggle::make('is_paid')
                    ->required(),
                Select::make('conference_id')
                    ->relationship('conference', 'name')
                    ->required(),
            ]);
    }
}
