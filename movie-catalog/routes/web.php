<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\QueryBuilderController; 

// Автоматический редирект с главной страницы в каталог фильмов
Route::get('/', function () {
    return redirect()->route('movies.index');
});

// Страница личного кабинета
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Управление профилем пользователя (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Публичные маршруты (доступны всем гостям)
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

// Демонстрационная страница со сложными JOIN-запросами Query Builder
Route::get('/debug-query', [QueryBuilderController::class, 'demo'])->name('query.demo');

// Маршруты для СОЗДАНИЯ новых фильмов через форму на сайте (для авторизованных)
// ВАЖНО: Они стоят строго НАД маршрутом {movie}, чтобы Laravel не путал слово "create" с ID фильма
Route::middleware('auth')->group(function () {
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});

// Публичный просмотр конкретного фильма
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Защищенные маршруты для отзывов и Избранного (только для авторизованных пользователей)
Route::middleware('auth')->group(function () {
    // Маршрут для сохранения нового отзыва
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Маршрут для удаления отзыва и оценки
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Маршруты для работы системы Избранного (сердечки)
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});


