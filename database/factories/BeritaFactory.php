<?php

namespace Database\Factories;

use App\Models\Berita;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
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
            'slug' => fake()->unique()->slug(),
            'excerpt' => fake()->sentence(),
            'content' => '<p>'.fake()->paragraph().'</p>',
            'image' => 'images/berita-web.png',
            'status' => 'terbit',
            'published_at' => now()->subDay(),
            'is_featured' => false,
        ];
    }
}
