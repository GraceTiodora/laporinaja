<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Solution;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        $users = User::factory(5)->create();

        // Seed Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laporinaja.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Seed Categories with fixed names
        $categories = [
            'Infrastructure' => 'Infrastructure issues',
            'Health' => 'Health and safety concerns',
            'Education' => 'Education related problems',
            'Environment' => 'Environmental issues',
            'Public Safety' => 'Public safety concerns',
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'slug' => str()->slug($name),
                'description' => $description,
            ]);
        }

        $categories = Category::all();

        // Seed Reports
        $reports = [];
        for ($i = 0; $i < 10; $i++) {
            $reports[] = Report::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'title' => fake()->sentence(),
                'description' => fake()->paragraphs(3, true),
                'location' => fake()->address(),
                'image' => null,
                'status' => fake()->randomElement(['pending', 'in_progress', 'resolved', 'rejected']),
                'upvotes' => fake()->numberBetween(0, 50),
                'downvotes' => fake()->numberBetween(0, 20),
                'resolved_at' => fake()->optional(0.3)->dateTime(),
            ]);
        }

        // Seed Comments
        foreach ($reports as $report) {
            for ($i = 0; $i < fake()->numberBetween(1, 5); $i++) {
                Comment::create([
                    'report_id' => $report->id,
                    'user_id' => $users->random()->id,
                    'content' => fake()->sentence(20),
                    'upvotes' => fake()->numberBetween(0, 30),
                    'downvotes' => fake()->numberBetween(0, 10),
                ]);
            }
        }

        // Seed Solutions
        foreach ($reports as $report) {
            for ($i = 0; $i < fake()->numberBetween(0, 3); $i++) {
                Solution::create([
                    'report_id' => $report->id,
                    'user_id' => $users->random()->id,
                    'description' => fake()->paragraphs(2, true),
                    'upvotes' => fake()->numberBetween(0, 40),
                    'downvotes' => fake()->numberBetween(0, 15),
                    'is_accepted' => fake()->boolean(20),
                ]);
            }
        }

        // Seed Votes
        foreach ($reports as $report) {
            $userIds = $users->pluck('id')->toArray();
            $votedUsers = [];
            
            for ($i = 0; $i < fake()->numberBetween(1, min(count($userIds), 8)); $i++) {
                do {
                    $userId = $userIds[array_rand($userIds)];
                } while (in_array($userId, $votedUsers));
                
                $votedUsers[] = $userId;
                
                Vote::create([
                    'user_id' => $userId,
                    'votable_id' => $report->id,
                    'votable_type' => Report::class,
                    'is_upvote' => fake()->boolean(70),
                ]);
            }
        }
    }
}
