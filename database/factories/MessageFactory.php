<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Channel;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'channel_id' => Channel::inRandomOrder()->first() ?: Channel::factory(),
            'user_id' => User::inRandomOrder()->first() ?: User::factory(),
            'message' => fake()->sentences(mt_rand(1, 3), true),
        ];
    }
}
