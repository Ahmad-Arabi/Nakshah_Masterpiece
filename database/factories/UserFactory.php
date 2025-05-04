<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default password for all users
            'role' => $this->faker->randomElement(['user', 'admin']),
            'city' => $this->faker->city(),
            'phone' => $this->faker->phoneNumber(),
            'profile_picture' => null,
            'remember_token' => Str::random(10),
        ];
    }
}