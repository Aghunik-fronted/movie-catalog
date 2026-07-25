<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Сохранение нового отзыва в базе данных.
     */
    public function store(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:5',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'movie_id' => $movie->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'Отзыв успешно добавлен!');
    }

    public function destroy(Review $review)
    {
        // Проверяем на бэкенде, что отзыв удаляет именно тот, кто его написал
        if (Auth::id() !== $review->user_id) {
            return redirect()->back()->with('error', 'Вы не можете удалить чужой отзыв!');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Отзыв и оценка успешно удалены!');
    }
}
