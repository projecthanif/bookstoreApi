<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word,
            'description' => $this->faker->sentence(),
            'discount_percent' => $this->faker->randomFloat(2, 1, 100),
            'start_date' => $this->faker->dateTimeThisDecade(),
            'end_date' => $this->faker->dateTimeThisDecade(),
        ];
    }
}
