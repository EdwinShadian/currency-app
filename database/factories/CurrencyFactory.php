<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\Currency
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class CurrencyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'short_name' => strtoupper($this->faker->lexify('???')),
            'full_name' => $this->faker->sentence,
            'rate_to_usd' => (string) $this->faker->randomFloat(2, 0.1, 10),
            'updated_at_date' => now()->toDate(),
        ];
    }
}
