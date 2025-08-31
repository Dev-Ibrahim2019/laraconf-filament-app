<?php

namespace App\Filament\Resources\Venues\Schemas;

use App\Models\Venue;
use Filament\Schemas\Schema;

class VenueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(Venue::getForm());
    }
}
