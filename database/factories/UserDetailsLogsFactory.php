<?php

namespace Database\Factories;

use App\Models\UserDetails;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserDetailsLogs>
 */
class UserDetailsLogsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => UserDetails::all()->random()->user_id,
            'action_performed' => fake()->randomElement(['login' , 'logout']),
            'status' =>fake()->randomElement(['successful' , 'failed']),
            'user_logs_created_at' => fake()->dateTime($max='now'),
            'user_logs_updated_at' => fake()->dateTime($max='now')
        ];
    }
}
