<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    // Получение списка всех фильмов
    public function index(): MovieCollection
    {
        return new MovieCollection(Movie::query()->paginate(1));
    }

    // Получение информации о конкретном фильме по ID
    public function show(Movie $movie): MovieResource
    {
        return new MovieResource($movie);
    }

    // Создание нового фильма
    public function store(StoreMovieRequest $request): MovieResource
    {
        $validated = $request->validated();

        $movie = Movie::query()->create($validated);

        return new MovieResource($movie);
    }

    // Обновление информации о фильме
    public function update(UpdateMovieRequest $request, Movie $movie): MovieResource
    {
        $validated = $request->validated();

        $movie->update($validated);

        return new MovieResource($movie);
    }

    // Удаление фильма
    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}
