<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use App\Models\Director;
use Carbon\Carbon;

class MoviesControllerTest extends TestCase
{

    use RefreshDatabase;
    public static function user() {
        return User::factory()->create();
    }


    /**
     * A basic feature test example.
     */
    public function testIndexUnauthorized(): void
    {
        $response = $this->get('/api/movies');

        $response->assertStatus(401);
    }
    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {

        $response = $this->actingAs($this->user())->get('/api/movies');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     */
    public function testIndexNameFilter(): void
    {

        $movieId = Movie::factory()->state(['title' => 'Star Wars Episode 2: Attack of The clones'])->create();
        $movieId = Movie::factory()->state(['title' => 'Star Wars Episode VII: The Last Jedi'])->create();
        $response = $this->actingAs($this->user())->get('/api/movies/?title=clones');
        $response->assertJsonCount(1, 'message.data');
        $response->assertJsonPath('message.data.0.title',
                                 'Star Wars Episode 2: Attack of The clones');

    }

    /**
     * Allow to filter by release date 
     */
    public function testIndexReleaseDateFromFilter(): void
    {

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2016-01-23')])->create();

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2010-01-23')])->create();
       $response = $this->actingAs($this->user())->get('/api/movies/?release_date_from=2015-01-23');
       $response->assertJsonCount(1, 'message.data');
       $response->assertJsonPath('message.data.0.release_date',
                                 '2016-01-23 00:00:00');

    }

  public function testIndexReleaseDateToFilter(): void
    {

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2016-01-23')])->create();
        $movieId = Movie::factory()->state(['release_date' => new Carbon('2015-01-23')])->create();

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2010-01-23')])->create();
       $response = $this->actingAs($this->user())->get('/api/movies/?release_date_to=2015-01-23');
       $response->assertJsonCount(1, 'message.data');
       $response->assertJsonPath('message.data.0.release_date',
                                 '2010-01-23 00:00:00');
    }

  public function testIndexReleaseDateRangeFilter(): void
    {

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2016-01-23')])->create();
        $movieId = Movie::factory()->state(['release_date' => new Carbon('2015-01-23')])->create();

        $movieId = Movie::factory()->state(['release_date' => new Carbon('2010-01-23')])->create();
       $response = $this->actingAs($this->user())->get('/api/movies/?release_date_from=2014-01-23&release_date_to=2015-06-06');
       $response->assertJsonCount(1, 'message.data');
       $response->assertJsonPath('message.data.0.release_date',
                                 '2015-01-23 00:00:00');
    }

    /**
     * Allow to filter by director name 
     */
    public function testIndexFilterByDirectorName(): void
    {

        Movie::factory()->create();

        $movie = Movie::factory()->create();

       $response = $this->actingAs($this->user())->get('/api/movies/?director=' . $movie->director->name);
       $response->assertJsonCount(1, 'message.data');
       $response->assertJsonPath('message.data.0.director.name',
                                 $movie->director->name);

    }


    public function testStoreValid(): void
    {

        $director = Director::factory()->create();
        $valid_parameters = [
           
            'title' =>  'Dune',
            'synopsis' =>  'Lorem ipsum dolor sit amet',
            'genre' =>  'Sci-Fi',
            'pg_rating' =>  '13',
            'release_date' =>   new Carbon('2016-01-23'),
            'director_id' => $director->id 
        ];
        $response = $this->actingAs($this->user())->postJson('/api/movies',$valid_parameters );

        $response->assertStatus(201);
        $response->assertJson(fn (AssertableJson $json) =>
                             $json->where('title', 'Dune')
                                   ->where('synopsis', 'Lorem ipsum dolor sit amet')
                                   ->where('genre', 'Sci-Fi')
                                   ->where('pg_rating', '13')
                                   ->has('director',
                                         fn($json) =>
                                         $json->where('name', $director->name)
                                              ->where('date_of_birth', $director->date_of_birth)->etc()
                                   )
                                   ->etc()
        );

        
    }


    public function testStoreInvalid(){
        $invalid_parameters = [
            'title' =>  null,
            'genre' =>  'Sci-Fi',
            'pg_rating' =>  97,
        ];
        $director = Director::factory()->create();
        $response = $this->actingAs($this->user())->postJson('/api/movies',$invalid_parameters );


        $response->assertStatus(422);
    }

    public function testShow(){
        
        $movie = Movie::factory()->create();
        $response = $this->actingAs($this->user())->get('/api/movies/' . $movie->id );

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
                             $json->where('title', $movie->title)
                                   ->where('synopsis', $movie->synopsis)
                                   ->where('genre', $movie->genre)
                                   ->where('pg_rating', $movie->pg_rating)
                                   ->has('director',
                                         fn($json) =>
                                         $json->where('name', $movie->director->name)
                                              ->where('date_of_birth', $movie->director->date_of_birth)->etc()
                                   )
                                   ->etc()
        );


    }

    public function testUpdateValid(){
        $update_attributes =['title' => 'Star Wars'];
        
        $movie = Movie::factory()->create();
        $response = $this->actingAs(
            $this->user())->patchJson('/api/movies/' . $movie->id,
                                      $update_attributes );
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
                             $json->where('title', 'Star Wars')
                                   ->where('synopsis', $movie->synopsis)
                                   ->where('genre', $movie->genre)
                                   ->where('pg_rating', $movie->pg_rating)
                                   ->has('director',
                                         fn($json) =>
                                         $json->where('name', $movie->director->name)
                                              ->where('date_of_birth', $movie->director->date_of_birth)->etc()
                                   )
                                   ->etc()
        );


    }

   public function testUpdateInvalid(){

       $movieId = Movie::factory()->create()->id;
       $movie = Movie::factory()->create();
       $invalid_update_attributes = [ 'title' => $movie->title ];
        
       $response = $this->actingAs(
           $this->user())->patchJson('/api/movies/' . $movieId
                                     , $invalid_update_attributes );
       $response->assertStatus(422);

   }


   public function testDelete(){

       $movieId = Movie::factory()->create()->id;
        
       $response = $this->actingAs(
           $this->user())->deleteJson('/api/movies/' . $movieId);
       $response->assertStatus(202);
       $this->assertNull(Movie::find($movieId));
   }


}
