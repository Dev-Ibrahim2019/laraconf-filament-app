<?php

namespace App\Filament\Resources\Talks\Pages;

use App\Enums\TalkStatus;
use App\Filament\Resources\Talks\TalkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListTalks extends ListRecords
{
    protected static string $resource = TalkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    /**
     * @return array<string | int, Tab>
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Talks'),
            'approved' => tab::make('Approved')
                ->modifyqueryusing(function ($query) {
                    return $query->where('status', talkstatus::APPROVED);
                }),
            'submitted' => tab::make('Submitted')
                ->modifyqueryusing(function ($query) {
                    return $query->where('status', talkstatus::SUBMITTED);
                }),
            'rejected' => tab::make('Rejected')
                ->modifyqueryusing(function ($query) {
                    return $query->where('status', talkstatus::REJECTED);
                }),
        ];
    }
}
