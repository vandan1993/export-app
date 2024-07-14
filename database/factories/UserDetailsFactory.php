<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetails>
 */
class UserDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->unique()->randomNumber(5),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' =>Hash::make('password'),
            'status' => 'Active',
            'user_created_at' => fake()->dateTime($max='now'),
            'user_updated_at' => fake()->dateTime($max='now')
        ];
    }
}
