@extends('layouts.app')

@section('title', $movie->title . ' | КиноКаталог')
@section('header', $movie->title)

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="px-4 sm:px-0">
                <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-150 group">
                    <span class="transform group-hover:-translate-x-1 transition duration-150">←</span> 
                    <span>Назад к списку фильмов</span>
                </a>
            </div>
            
            <!-- Информация о фильме -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-6 relative transition-colors duration-200">
                @if($movie->poster)
                    <img src="/{{ $movie->poster }}" alt="{{ $movie->title }}" class="w-full md:w-64 h-auto object-contain rounded-md shadow-lg">
                @endif
                <div class="flex-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <h3 class="font-bold text-2xl text-gray-900 dark:text-white">{{ $movie->title }}</h3>
                            
                            <div class="flex items-center gap-3">
                                @auth
                                    @if(Auth::user()->is_admin || Auth::id() === $movie->user_id)
                                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите навсегда удалить этот фильм и все отзывы?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-md transition cursor-pointer">
                                                🗑️ Удалить фильм
                                            </button>
                                        </form>
                                    @endif
                                @endauth

                                @auth
                                    <form action="{{ route('favorites.toggle', $movie->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2.5 bg-gray-200/80 dark:bg-gray-900/80 hover:bg-gray-200 dark:hover:bg-gray-900 rounded-full transition-all duration-150 transform hover:scale-110 shadow-lg cursor-pointer">
                                            @if($movie->isFavoritedBy(Auth::user()))
                                                <span class="text-red-500 text-xl">❤️</span>
                                            @else
                                                <span class="text-gray-400 hover:text-red-400 text-xl">🤍</span>
                                            @endif
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Форма отправки отзыва -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Оставить отзыв</h4>
                
                @auth
                    @if(session('success'))
                        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950/50 border border-green-200 dark:border-green-800 p-3 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reviews.store', $movie->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ваша оценка</label>
                            <div class="flex flex-row-reverse justify-end items-center gap-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required>
                                    <label for="star{{ $i }}" class="text-3xl text-gray-400 dark:text-gray-600 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors duration-150">★</label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ваш отзыв</label>
                            <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md bg-white border-gray-300 text-gray-900 dark:bg-gray-900 dark:border-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-400 dark:placeholder-gray-500" placeholder="Напишите ваше мнение..." required></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 shadow-md transition">
                            Отправить отзыв
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        Чтобы оставить отзыв, пожалуйста, <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">войдите в аккаунт</a>.
                    </p>
                @endauth
            </div>

            <!-- Список отзывов -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                <h4 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Отзывы пользователей</h4>
                <div class="space-y-4">
                    @forelse($movie->reviews as $review)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $review->user->name }}</span>
                                <span class="text-yellow-500 dark:text-yellow-400 font-bold tracking-wider">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $review->content }}</p>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                @auth
                                    @if(Auth::id() === $review->user_id)
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Вы уверены?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 dark:text-red-400 hover:underline cursor-pointer">
                                                Удалить отзыв
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm italic">Отзывов пока нет. Будьте первым, кто оставит своё мнение!</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection


