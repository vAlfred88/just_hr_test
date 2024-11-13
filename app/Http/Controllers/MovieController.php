<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Получение списка всех фильмов
    public function index(): Collection
    {
        return Movie::all();
    }

    // Получение информации о конкретном фильме по ID
    public function show($id)
    {
        return Movie::findOrFail($id);
    }

    // Создание нового фильма
    public function store(StoreMovieRequest $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'duration' => 'required|integer',
            'release_year' => 'required|integer|digits:4',
            'genre' => 'required|string|max:100',
            'director' => 'required|string|max:150',
        ]);

        return Movie::create($validatedData);
    }

    // Обновление информации о фильме
    public function update(UpdateMovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'string|max:200',
            'duration' => 'integer',
            'release_year' => 'integer|digits:4',
            'genre' => 'string|max:100',
            'director' => 'string|max:150',
        ]);

        $movie->update($validatedData);
        return $movie;
    }

    // Удаление фильма
    public function destroy($id): JsonResponse
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}
