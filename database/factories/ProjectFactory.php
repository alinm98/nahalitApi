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
    public function definition()
    {
        return [
            'title' => fake()->jobTitle,
            'supervisor_id' => 1,
            'description' => fake()->text('200'),
            'price' => 10000,
            'category_id' => 1,
            'file' => 'test',
            'confirm' => true,
            'status' => 'waiting',
            'progress' => 50
        ];
    }
}
