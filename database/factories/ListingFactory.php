<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement([1, 2]),
            'title' => $this->faker->sentence(),
            'desc' => $this->faker->paragraph(12),
            'email' => $this->faker->unique()->safeEmail(),
            'link' => $this->faker->url(),
            'tags' =>$this->faker->randomElement([
                'dev,game',
                'game',
                'biz,tech',
                'tech,game,biz'
            ]),
            'approved' => 1,
        ];
    }
}
