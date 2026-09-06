<?php

namespace Database\Factories;

use App\Models\Destiny;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Destiny>
 */
class DestinyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->city(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode()
        ];
    }
}
