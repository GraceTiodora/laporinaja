<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraphs(3, true),
            'location' => fake()->address(),
            'image' => null,
            'status' => fake()->randomElement(['pending', 'in_progress', 'resolved', 'rejected']),
            'upvotes' => fake()->numberBetween(0, 50),
            'downvotes' => fake()->numberBetween(0, 20),
            'resolved_at' => fake()->optional(0.3)->dateTime(),
        ];
    }
}
