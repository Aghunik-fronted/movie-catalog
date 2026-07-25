<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Вывод списка фильмов (с поддержкой поиска и пагинации).
     */
    public function index(Request $request)
    {
        // Базовый запрос с ленивой загрузкой отзывов
        $movies = Movie::with('reviews')
            // Условие выполнится, только если в GET-запросе передан непустой параметр 'search'
            ->when($request->filled('search'), function ($query) use ($request) {
                $searchTerm = $request->input('search');
                
                // Группируем условия WHERE во избежание конфликтов приоритетов SQL
                return $query->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            })
            ->latest() // Сортировка: сначала новые поступления
            ->paginate(12) // Постраничный вывод по 12 элементов
            ->withQueryString(); // Сохраняет параметр поиска при переходе по страницам пагинации

        return view('movies.index', compact('movies'));
    }

    /**
     * Отображение конкретного фильма.
     */
    public function show(Movie $movie)
    {
        $movie->load('reviews.user');
        return view('movies.show', compact('movie'));
    }

        public function create()
    {
        // Показ формы создания фильма
        return view('movies.create');
    }

    public function store(Request $request)
    {
        // Валидация входных данных формы
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:movies,title',
            'description' => 'required|string|min:10',
            'poster_file' => 'nullable|image|mimes:webp,jpeg,jpg,png|max:2048'
        ]);

        $posterPath = 'posters/interstellar.webp'; // дефолтный постер, если не загружен свой

        // Если загружен файл обложки, сохраняем его в public/posters
        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('posters'), $filename);
            $posterPath = 'posters/' . $filename;
        }

        // Создаем запись в базе данных
        Movie::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'poster' => $posterPath
        ]);

        return redirect()->route('movies.index')->with('success', 'Новый фильм успешно добавлен в кинотеатр!');
    }
}
