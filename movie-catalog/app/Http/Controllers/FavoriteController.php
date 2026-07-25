<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Отображение списка избранных фильмов текущего пользователя.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Теперь Intelephense на 100% видит метод favoriteMovies()
        $movies = $user->favoriteMovies()->with('reviews')->get();
        
        $title = 'Избранные фильмы';
        $header = 'Моё Избранное';

        return view('movies.index', compact('movies', 'title', 'header'));
    }

    /**
     * Добавление или удаление фильма из избранного (Toggle).
     */
    public function toggle(Movie $movie)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->favoriteMovies()->where('movie_id', $movie->id)->exists()) {
            $user->favoriteMovies()->detach($movie->id);
            $message = 'Фильм удален из избранного';
        } else {
            $user->favoriteMovies()->attach($movie->id);
            $message = 'Фильм добавлен в избранное! ❤️';
        }

        return redirect()->back()->with('success', $message);
    }
}

