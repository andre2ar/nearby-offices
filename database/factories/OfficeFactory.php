<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "affiliate_id" => fake()->unique()->randomNumber(null),
            "name" => fake()->name,
            "latitude" => fake()->latitude(51, 55),
            "longitude" => fake()->longitude(-10, -5)
        ];
    }
}
