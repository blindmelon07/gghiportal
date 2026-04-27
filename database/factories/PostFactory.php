<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(5);
        return [
            'title'       => $title,
            'slug'        => Str::slug($title) . '-' . $this->faker->unique()->randomNumber(4),
            'excerpt'     => $this->faker->paragraph(2),
            'body'        => implode("\n\n", $this->faker->paragraphs(5)),
            'category'    => $this->faker->randomElement(['Health Tips', 'News', 'Research', 'Events']),
            'author_name' => 'Dr. ' . $this->faker->name(),
            'is_published'=> false,
            'published_at'=> null,
        ];
    }

    public function published(): static
    {
        return $this->state(['is_published' => true, 'published_at' => now()]);
    }

    public function draft(): static
    {
        return $this->state(['is_published' => false, 'published_at' => null]);
    }
}
