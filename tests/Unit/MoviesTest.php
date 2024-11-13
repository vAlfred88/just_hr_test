<?php

namespace Tests\Unit;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class MoviesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_movie()
    {
        $movieData = [
            'title' => 'Inception',
            'duration' => 148,
            'release_year' => 2010,
            'genre' => 'Sci-Fi',
            'director' => 'Christopher Nolan',
        ];

        $movie = Movie::create($movieData);

        $this->assertDatabaseHas('movies', $movieData);
    }

    /** @test */
    public function it_can_get_a_movie_by_id()
    {
        $movie = Movie::factory()->create();

        $foundMovie = Movie::find($movie->id);

        $this->assertNotNull($foundMovie);
        $this->assertEquals($movie->title, $foundMovie->title);
    }

    /** @test */
    public function it_can_update_a_movie()
    {
        $movie = Movie::factory()->create([
            'title' => 'Old Title',
        ]);

        $movie->update(['title' => 'New Title']);

        $this->assertDatabaseHas('movies', ['title' => 'New Title']);
        $this->assertDatabaseMissing('movies', ['title' => 'Old Title']);
    }

    /** @test */
    public function it_can_delete_a_movie()
    {
        $movie = Movie::factory()->create();

        $movie->delete();

        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
}
