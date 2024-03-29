<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->sentence(3),
            'description' => fake()->text,
            'start_time' => fake()->dateTimebetween('now', '+1 month'),
            'end_time' => fake()->dateTimebetween('+1 month', '+2 months'),
            // 'end_time'  => function (array $attributes) {
            //     return fake()->dateTimeBetween($attributes['start_time'], '+1 month')
            // }
        ];
    }
}
