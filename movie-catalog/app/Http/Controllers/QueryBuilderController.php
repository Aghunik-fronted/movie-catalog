<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueryBuilderController extends Controller
{
    public function demo()
    {
        // Привер 1: Выборка топ-фильмов через Inner Join и сортировку конструктора запросов
        $topMovies = DB::table('movies')
            ->join('reviews', 'movies.id', '=', 'reviews.movie_id')
            ->select('movies.title', DB::raw('AVG(reviews.rating) as average_rating'))
            ->groupBy('movies.id', 'movies.title')
            ->orderBy('average_rating', 'desc')
            ->limit(5)
            ->get();

        // Пример 2: Статистика базы данных (агрегатные функции)
        $stats = DB::table('reviews')
            ->select(DB::raw('count(*) as total_reviews, avg(rating) as global_avg'))
            ->first();

        // Возвращаем простой JSON для демонстрации преподавателю на защите
        return response()->json([
            'info' => 'Демонстрация работы конструктора запросов Query Builder',
            'top_movies_by_join' => $topMovies,
            'database_stats' => $stats
        ]);
    }
}
