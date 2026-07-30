<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Импортируем фасад Auth

class MovieController extends Controller
{
    /**
     * Список всех фильмов с поиском и пагинацией.
     */
    public function index(Request $request)
    {
        $query = Movie::with('reviews')->latestFirst();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $movies = $query->paginate(6);

        return view('movies.index', compact('movies'));
    }

    /**
     * Показ детальной страницы конкретного фильма с отзывами.
     */
    public function show(Movie $movie)
    {
        $movie->load('reviews.user');
        return view('movies.show', compact('movie'));
    }

    /**
     * Форма создания нового фильма.
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Сохранение нового фильма в базу данных.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title',
            'description' => 'required|string|min:10',
            'poster_file' => 'nullable|image|mimes:webp,jpeg,jpg,png|max:2048'
        ]);

        $posterPath = 'posters/interstellar.webp';

        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('posters'), $filename);
            $posterPath = 'posters/' . $filename;
        }

        Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'poster' => $posterPath,
            'user_id' => Auth::user() ? Auth::user()->id : null
        ]);

        return redirect()->route('movies.index')->with('success', 'Новый фильм успешно добавлен в каталог!');
    }

    /**
     * Удаление фильма автором или администратором.
     */
    public function destroy(Movie $movie)
    {
        if (!Auth::check() || (!Auth::user()->is_admin && Auth::user()->id !== $movie->user_id)) {
            abort(403, 'Доступ запрещен! Вы можете удалять только свои фильмы.');
        }

        if ($movie->poster && $movie->poster !== 'posters/interstellar.webp' && file_exists(public_path($movie->poster))) {
            unlink(public_path($movie->poster));
        }

        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Фильм успешно удален из каталога!');
    }
}
