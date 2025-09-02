<?php

namespace App\Livewire;

use App\Models\Attendee;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class ConferenceSignUpPage extends Component implements HasSchemas, HasActions
{
    use InteractsWithActions, InteractsWithSchemas;

    public int $conferenceId;
    public int $price = 50000;

    public function mount()
    {
        $this->conferenceId = 1;
    }

    public function signUpAction(): Action
    {
        return Action::make('signUp')
            ->slideOver()
            ->label('Sign Up')
            ->icon('heroicon-o-user-plus')
            ->color('primary')
            ->schema([
                Placeholder::make('total_price')
                    ->content(function (Get $get) {
                        return '$' . count($get('attendees')) * 500;
                    }),
                Repeater::make('attendees')
                    ->schema(Attendee::getForm())
                    ->minItems(1)
                    ->maxItems(10),
            ])
            ->action(function (array $data) {
                collect($data['attendees'])->each(function ($attendeeData) {
                    Attendee::create([
                        'conference_id' => $this->conferenceId,
                        'ticket_cost' => $this->price,
                        'name' => $attendeeData['name'],
                        'email' => $attendeeData['email'],
                        'is_paid' => true,
                    ]);
                });
            })
            ->after(function () {
                Notification::make()
                    ->success()
                    ->title('Success')
                    ->body('You have successfully signed up for the conference!')
                    ->send();
            });
    }

    public function render()
    {
        return view('livewire.conference-sign-up-page');
    }
}
