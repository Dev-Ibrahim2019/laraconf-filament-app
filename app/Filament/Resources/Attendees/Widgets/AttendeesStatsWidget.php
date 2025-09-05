<?php

namespace App\Filament\Resources\Attendees\Widgets;

use App\Filament\Resources\Attendees\Pages\ListAttendees;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AttendeesStatsWidget extends StatsOverviewWidget
{
    use InteractsWithPageTable;

    protected function getColumns(): int|array|null
    {
        return 2;
    }

    protected function getTablePage(): string
    {
        return ListAttendees::class;
    }

    protected function getStats(): array
    {
        $data = Trend::query($this->getPageTableQuery())
            ->between(
                now()->subMonth(),
                now()
            )
            ->perDay()
            ->count();

        return [
            Stat::make('Attendees Count', $this->getPageTableQuery()->count())
                ->description('Total number of attendees')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success')
                ->chart($data->map(fn (TrendValue $value) => $value->aggregate)),
            Stat::make('Total Revenue', $this->getPageTableQuery()->sum('ticket_cost') / 1000),
        ];
    }
}
