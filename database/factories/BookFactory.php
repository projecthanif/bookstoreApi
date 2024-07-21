<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->sentence(),
            'isbn' =>  $this->faker->isbn13(),
            'publication_date' => $this->faker->dateTimeThisDecade(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'currency' => $this->faker->currencyCode(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'publisher' => $this->faker->company,
            'genre_id' => Genre::factory(),
        ];
    }
}
