<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MoviesApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_movie_via_api()
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
            ->assertJsonFragment($movieData);

        $this->assertDatabaseHas('movies', $movieData);
    }

    /** @test */
    public function it_can_get_a_list_of_movies_via_api()
    {
        $movies = Movie::factory()->count(3)->create();

        $response = $this->getJson('/api/movies');

        $response->assertStatus(200)
            ->assertJsonCount(3); // Ожидаем, что вернется 3 фильма
    }

    /** @test */
    public function it_can_get_a_single_movie_via_api()
    {
        $movie = Movie::factory()->create();

        $response = $this->getJson("/api/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $movie->id,
                'title' => $movie->title,
            ]);
    }

    /** @test */
    public function it_can_update_a_movie_via_api()
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

    /** @test */
    public function it_can_delete_a_movie_via_api()
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/api/movies/{$movie->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Movie deleted successfully']);

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
