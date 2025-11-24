<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solution>
 */
class SolutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'report_id' => Report::factory(),
            'user_id' => User::factory(),
            'description' => fake()->paragraphs(2, true),
            'upvotes' => fake()->numberBetween(0, 40),
            'downvotes' => fake()->numberBetween(0, 15),
            'is_accepted' => fake()->boolean(20),
        ];
    }
}
