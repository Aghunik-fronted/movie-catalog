<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('reviews')->get();
        return view('movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        $movie->load('reviews.user');
        return view('movies.show', compact('movie'));
    }
}
