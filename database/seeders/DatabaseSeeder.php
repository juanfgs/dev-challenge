<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Series;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Movie::factory()
            ->count(15)
            ->hasDirector(1)
            ->hasActors(5)
            ->create();

       Series::factory()
            ->count(15)
            ->hasEpisodes(15)
            ->hasActors(12)
            ->create();
    }
}
