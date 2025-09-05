<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendee>
 */
class AttendeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'ticket_cost' => fake()->numberBetween(50, 500),
            'is_paid' => 'true',
            // 'conference_id' => Conference::factory(),
            'created_at' => fake()->dateTimeBetween('-3 months', 'now')
        ];
    }
}
