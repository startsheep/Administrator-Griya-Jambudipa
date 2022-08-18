<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'position_id' => 1,
            'phone' => mt_rand(00000000, 999999),
            'gender' => 'L',
            'entry_date' => now(),
            'address' => fake()->address(),
            'image' => fake()->imageUrl(),
            'is_active' => 1,
            'status' => 1,
        ];
    }
}
