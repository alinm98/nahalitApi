<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->title,
            'image' => asset('Admin/Images/without-thumbnail.jpg'),
            'slug' => fake()->slug,
            'body' => fake()->text(250),
            'is_active' => false,
            'user_id' => null
        ];
    }
}
