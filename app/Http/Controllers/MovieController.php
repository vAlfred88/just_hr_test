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
        return Movie::create($request->validated());
    }

    // Обновление информации о фильме
    public function update(UpdateMovieRequest $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $movie->update($request->validated());
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
