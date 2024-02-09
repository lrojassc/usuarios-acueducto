<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'document_type' => 'CC',
            'document_number' => fake()->numberBetween(1, 123456789),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'old_code' => fake()->numberBetween(1, 500),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'municipality' => fake()->country(),
            'password' => static::$password ??= Hash::make('password'),
        ];
    }
}
