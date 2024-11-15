<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MoviesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_404_when_movie_is_not_found()
    {
        $response = $this->getJson('/api/movies/999');  // Несуществующий ID

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Resource not found'
            ]);
    }

    public function test_it_can_create_a_movie_via_api()
    {
        $movieData = [
            'title' => 'Inception',
            'duration' => 148,
            'release_year' => 2010,
            'genre' => 'Sci-Fi',
            'director' => 'Christopher Nolan',
        ];

        $response = $this->postJson('/api/movies', $movieData);

        $response->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) => $json->has('data')
                ->has('data', fn(AssertableJson $json) => $json->where('title', $movieData['title'])
                    ->where('duration', $movieData['duration'])
                    ->where('director', $movieData['director'])
                    ->etc()
                )
            );

        $this->assertDatabaseHas('movies', $movieData);
    }

    public function test_it_returns_validation_errors_when_creating_movie_with_invalid_data()
    {
        $movieData = [
            'title' => '',
            'duration' => false,
            'release_year' => 12025,
            'genre' => '',
            'director' => '',
        ];

        $response = $this->postJson('/api/movies', $movieData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'duration', 'genre', 'director', 'release_year']);

        $this->assertDatabaseMissing('movies', $movieData);
    }


    public function test_it_can_get_a_list_of_movies_via_api()
    {
        $movies = Movie::factory()->count(3)->create();

        $response = $this->getJson('/api/movies');

        $response->assertStatus(200)
            ->assertJson(fn(AssertableJson $json) => $json->has('data', 3)
                ->has('data.0', fn(AssertableJson $json) => $json->where('id', $movies->first()->id)
                    ->where('title', $movies->first()->title)
                    ->etc()
                )
            );
    }


    public function test_it_can_get_a_single_movie_via_api()
    {
        $movie = Movie::factory()->create();

        $response = $this->getJson("/api/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson(
                [
                    'data' => [
                        'id' => $movie->id,
                        'title' => $movie->title,
                    ]
                ]
            );
    }


    public function test_it_can_update_a_movie_via_api()
    {
        $movie = Movie::factory()->create([
            'title' => 'Old Title',
            'duration' => 120,
            'release_year' => 2000,
            'genre' => 'Action',
            'director' => 'Old Director',
        ]);

        $updatedData = [
            'title' => 'New Title',
            'duration' => 130,
            'release_year' => 2022,
            'genre' => 'Thriller',
            'director' => 'New Director',
        ];

        $response = $this->patchJson("/api/movies/{$movie->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('movies', $updatedData);
    }

    public function test_it_invalidated_can_not_update_a_movie_via_api()
    {
        $movie = Movie::factory()->create([
            'title' => 'Old Title',
            'duration' => 120,
            'release_year' => 2000,
            'genre' => 'Action',
            'director' => 'Old Director',
        ]);

        $updatedData = [
            'title' => null,
            'duration' => -120,
            'release_year' => 30000,
        ];

        $response = $this->patchJson("/api/movies/{$movie->id}", $updatedData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'duration', 'release_year']);

        $this->assertDatabaseMissing('movies', $updatedData);
    }


    public function test_it_can_delete_a_movie_via_api()
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/api/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Movie deleted successfully']);

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
