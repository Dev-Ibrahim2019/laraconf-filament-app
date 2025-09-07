<?php

namespace App\Filament\Resources\Attendees\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Awcodes\Shout\Components\Shout;
use Filament\Schemas\Components\Utilities\Get;

class AttendeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Shout::make('warn-price')
                    ->visible(function (Get $get) {
                        return $get('ticket_cost') > 500;
                    })
                    ->columnSpanFull()
                    ->type('warning')
                    ->content(function (Get $get) {
                        $price = $get('ticket_cost');
                        return 'This is ' . $price - 500 . ' more than the average ticket price';
                    }),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('ticket_cost')
                    ->lazy()
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
