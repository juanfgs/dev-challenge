<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Series;
use App\Models\User;

class EpisodesControllerTest extends TestCase
{

    use RefreshDatabase;

    public static function user() {
        return User::factory()->create();
    }

    /**
     * show episode and metadata 
     */
    public function testShowEpisode(): void
    {

        $series = Series::factory()
                ->hasEpisodes(10)
                ->hasActors(8)
                ->create();

        $episode =  $series->episodes()->first();
        $response = $this->actingAs($this->user())->get("/api/episodes/{$episode->id}");
        $response->assertStatus(200);
        $response->assertJsonPath('director.name',$episode->director->name);
        $response->assertJsonPath('series.name',$episode->series->name);
    }
}
