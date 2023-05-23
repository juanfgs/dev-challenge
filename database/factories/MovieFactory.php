<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Director;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' =>  fake()->name(),
            'synopsis' =>  fake()->text(),
            'genre' =>  fake()->name(),
            'release_date' =>  fake()->date(),
            'pg_rating' =>  '13',
            'director_id' => Director::factory()->create() 
        ];
    }
}
