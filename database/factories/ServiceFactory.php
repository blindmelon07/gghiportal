<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->words(2, true);
        return [
            'title'       => ucwords($title),
            'slug'        => Str::slug($title) . '-' . $this->faker->unique()->randomNumber(3),
            'icon'        => '🏥',
            'description' => $this->faker->paragraph(2),
            'is_featured' => true,
            'sort_order'  => $this->faker->numberBetween(0, 10),
            'is_active'   => true,
        ];
    }
}
