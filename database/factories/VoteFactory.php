<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $report = Report::factory()->create();
        return [
            'user_id' => User::factory(),
            'votable_id' => $report->id,
            'votable_type' => Report::class,
            'is_upvote' => fake()->boolean(70),
        ];
    }
}
