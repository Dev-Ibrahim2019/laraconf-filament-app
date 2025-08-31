<?php

namespace App\Livewire;

use App\Models\Attendee;
use App\Models\Conference;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ConferenceSignUpPage extends Component implements HasForms, HasActions
{
    use InteractsWithForms, InteractsWithActions;

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
            ->hiddenLabel()
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
                try {
                    // Validate conference exists
                    $conference = Conference::find($this->conferenceId);
                    if (!$conference) {
                        Notification::make()
                            ->title('Conference not found')
                            ->body('The selected conference could not be found.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Check for duplicate emails
                    $emails = collect($data['attendees'])->pluck('email');
                    $duplicates = Attendee::where('conference_id', $this->conferenceId)
                        ->whereIn('email', $emails)
                        ->exists();
                    
                    if ($duplicates) {
                        Notification::make()
                            ->title('Duplicate registration')
                            ->body('One or more attendees are already registered for this conference.')
                            ->danger()
                            ->send();
                        return;
                    }

                    DB::transaction(function () use ($data) {
                        collect($data['attendees'])->each(function ($attendeeData) {
                            Attendee::create([
                                'conference_id' => $this->conferenceId,
                                'ticket_cost' => $this->price,
                                'name' => $attendeeData['name'],
                                'email' => $attendeeData['email'],
                                'is_paid' => true,
                            ]);
                        });
                    });

                    Notification::make()
                        ->title('Registration successful')
                        ->body('All attendees have been successfully registered for the conference.')
                        ->success()
                        ->send();

                } catch (\Exception $e) {
                    Log::error('Conference sign-up failed', [
                        'conference_id' => $this->conferenceId,
                        'error' => $e->getMessage(),
                        'data' => $data
                    ]);

                    Notification::make()
                        ->title('Registration failed')
                        ->body('An error occurred while processing your registration. Please try again.')
                        ->danger()
                        ->send();
                }
            });
    }

    public function render()
    {
        return view('livewire.conference-sign-up-page');
    }
}
