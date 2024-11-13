<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'duration' => $this->faker->numberBetween(60, 180),
            'release_year' => $this->faker->year(),
            'genre' => $this->faker->word(),
            'director' => $this->faker->name(),
        ];
    }
}
