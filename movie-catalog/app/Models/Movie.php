<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder; // ДОБАВЛЕН ИМПОРТ ДЛЯ ТИПИЗАЦИИ SCOPE
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    protected $fillable = ['title', 'description', 'poster', 'user_id'];

    /**
     * Связь: Один фильм имеет много отзывов
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Связь: Фильм принадлежит многим пользователям через таблицу избранного
     */
    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    /**
     * Проверка, добавлен ли фильм в избранное конкретным пользователем
     */
    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }
        
        return $this->favoritedByUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Scope: Сортировка фильмов: сначала новые
     */
    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->latest();
    }

    /**
     * Scope: Фильмы, у которых есть отзывы с оценкой 5
     */
    public function scopeTopRated(Builder $query): Builder
    {
        return $query->whereHas('reviews', function (Builder $q) {
            $q->where('rating', 5);
        });
    }
}
