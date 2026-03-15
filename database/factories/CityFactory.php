<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'county_name' => fake()->name(120),
            // 'zip' => fake()->integer(10),
            // 'city_name' => fake()->name(120),
            // 'state_id' => fake()->integer(2)
        ];
    }
}
