<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\QueryBuilderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// Автоматический редирект с главной страницы в каталог фильмов
Route::get('/', function () {
    return redirect()->route('movies.index');
});

// Страница личного кабинета (для обычных пользователей)
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

// Демонстрационная страница со сложными JOIN-запросами Query Builder (для экзамена)
Route::get('/debug-query', [QueryBuilderController::class, 'demo'])->name('query.demo');

// Маршруты для СОЗДАНИЯ новых фильмов через форму на сайте (для авторизованных)
Route::middleware('auth')->group(function () {
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
});

// Публичный просмотр конкретного фильма
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Защищенные маршруты для отзывов, Избранного и Удаления фильмов
Route::middleware('auth')->group(function () {
    // Маршрут для сохранения нового отзыва
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Маршрут для удаления отзыва и оценки
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Маршруты для работы системы Избранного (сердечки)
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

// Защищенные маршруты исключительно для Панели Администратора
Route::middleware(['auth'])->group(function () {
    
    Route::group(['middleware' => function ($request, $next) {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ запрещен! Вы не администратор.');
        }
        return $next($request);
    }], function () {
        // Административный дашборд (Центр управления)
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Главная страница админки (список пользователей)
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
        
        // Маршруты блокировки и разблокировки пользователей
        Route::post('/admin/users/{user}/block', [AdminController::class, 'block'])->name('admin.users.block');
        Route::post('/admin/users/{user}/unblock', [AdminController::class, 'unblock'])->name('admin.users.unblock');
        
        // Полное удаление аккаунта пользователя из базы
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    });

});


