<?php

namespace App\Filament\Resources\Talks\Tables;

use App\Enums\TalkLength;
use App\Enums\TalkStatus;
use App\Models\Talk;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TalksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->filtersTriggerAction(function ($action) {
                return $action->button()->label('Filters');
            })
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->description(function (Talk $record) {
                        return Str::of($record->abstract)->limit(40);
                    }),
                ImageColumn::make('speaker.avatar')
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($record->speaker->name);
                    })->circular()
                    ->imageSize(40),
                TextColumn::make('speaker.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('new_talk'),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(function ($state) {
                        return $state->getColor();
                    }),
                IconColumn::make('length')
                    ->icon(function ($state) {
                        return match ($state) {
                            TalkLength::NORMAL => 'heroicon-o-megaphone',
                            TalkLength::LIGHTNING => 'heroicon-o-bolt',
                            TalkLength::KEYNOTE => 'heroicon-o-key',
                        };
                    }),
            ])
            ->filters([
                TernaryFilter::make('new_talk'),
                SelectFilter::make('speaker')
                    ->relationship('speaker', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Filter::make('has_avatar')
                    ->label('Show Only Speakers with Avatars')
                    ->toggle()
                    ->query(function ($query) {
                        return $query->whereHas('speaker', function (Builder $query) {
                            $query->whereNotNull('avatar');
                        });
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver(),
                ActionGroup::make([
                    Action::make('Approve')
                        ->visible(function ($record) {
                            return $record->status !== TalkStatus::APPROVED;
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Talk $record) {
                            return $record->approve();
                        })->after(function () {
                            Notification::make()->success()->title('This talk was appvoed')
                                ->duration(1000)
                                ->body('The speaker has been nofifed and the talk has been added to the conference schedule.')
                                ->send();
                        }),
                    Action::make('Reject')
                        ->visible(function ($record) {
                            return $record->status !== TalkStatus::REJECTED;
                        })
                        ->icon('heroicon-o-no-symbol')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function (Talk $record) {
                            return $record->reject();
                        })->after(function () {
                            Notification::make()->danger()->title('This talk was rejected')
                                ->duration(1000)
                                ->body('The speaker has been nofifed')
                                ->send();
                        }),
                ])
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                DeleteBulkAction::make(),
                BulkAction::make('approve')
                    ->action(function (Collection $records) {
                        // $record->map(fn($record) => $record->approve());
                        $records->each->approve();
                    }),
                // ]),
            ])
            ->headerActions([
                Action::make('export')
                    ->tooltip('This wilt export att records visible in the table. Adjust filters to export a subset of records.')
                    ->action(function ($livewire) {
                        ray($livewire->getFilteredTableQuerey()->count());
                    }),
            ]);
    }
}
