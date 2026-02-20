<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'tech' => fake()->words(3),
            'live_url' => fake()->url(),
            'github_url' => fake()->url(),
            'thumbnail' => fake()->imageUrl(),
            'images' => [fake()->imageUrl()],
        ];
    }
}
