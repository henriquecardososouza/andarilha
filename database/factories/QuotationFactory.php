<?php

namespace Database\Factories;

use App\Models\Destiny;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quotation>
 */
class QuotationFactory extends Factory
{
    private const int MAX_DESTINIES_CACHED = 100;
    private ?Collection $_destinies = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'destiny_uuid' => $this->_randomDestiny(),
            'user_name' => $this->faker->name(),
            'user_email' => $this->faker->safeEmail(),
            'trip_date' => $this->faker->dateTimeBetween('+1 month', '+1 years'),
        ];
    }

    private function _randomDestiny(): string
    {
        if (is_null($this->_destinies)) {
            $this->_destinies = Destiny::query()
                ->select("uuid")
                ->inRandomOrder()
                ->limit(self::MAX_DESTINIES_CACHED)
                ->get();
        }

        if ($this->_destinies->isEmpty()) {
            throw new \RuntimeException("The system doesn't have any destinies registered, add at least one before running this factory");
        }

        return $this->_destinies->random()->uuid;
    }
}
