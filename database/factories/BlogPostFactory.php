<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'excerpt' => fake()->paragraph(),
            'content' => fake()->text(),
            'featured_image' => fake()->imageUrl(),
            'is_published' => fake()->boolean(),
            'published_at' => fake()->dateTime(),
            'meta_keywords' => fake()->words(3),
            'meta_description' => fake()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
