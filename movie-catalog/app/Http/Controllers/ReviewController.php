<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
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
}
