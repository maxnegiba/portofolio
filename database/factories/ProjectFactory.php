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
            'title' => [
                'en' => fake()->sentence(),
                'ro' => fake()->sentence(),
            ],
            'description' => [
                'en' => fake()->paragraph(),
                'ro' => fake()->paragraph(),
            ],
            'tech' => fake()->words(3),
            'live_url' => fake()->url(),
            'github_url' => fake()->url(),
            'thumbnail' => fake()->imageUrl(),
            'images' => [fake()->imageUrl()],
            'category' => 'web_platform',
            'problem' => [],
            'solution' => [],
            'business_result' => [],
        ];
    }
}
