<?php

namespace App\Filament\Resources\Conferences\Schemas;

use App\Enums\Region;
use App\Models\Conference;
use App\Models\Speaker;
use App\Models\Venue;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class ConferenceForm
{
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(Conference::getForm());
    }
}
