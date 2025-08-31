<?php

namespace App\Filament\Resources\Talks\Schemas;

use App\Models\Talk;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TalkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(Talk::getFrom());
    }
}
