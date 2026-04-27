<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name(),
            'email'   => $this->faker->safeEmail(),
            'phone'   => $this->faker->phoneNumber(),
            'subject' => $this->faker->sentence(3),
            'message' => $this->faker->paragraph(2),
            'is_read' => false,
        ];
    }

    public function unread(): static
    {
        return $this->state(['is_read' => false]);
    }

    public function read(): static
    {
        return $this->state(['is_read' => true]);
    }
}
