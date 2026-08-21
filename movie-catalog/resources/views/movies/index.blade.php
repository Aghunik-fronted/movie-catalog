@php 
    $title = $title ?? 'Все фильмы'; 
@endphp

@extends('layouts.app')

@section('title', $title . ' | КиноКаталог')
@section('header', $header ?? 'Каталог фильмов')

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(request()->routeIs('favorites.index'))
                <div class="mb-6 px-4 sm:px-0">
                    <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-150 group">
                        <span class="transform group-hover:-translate-x-1 transition duration-150">←</span> 
                        <span>Назад в общий каталог фильмов</span>
                    </a>
                </div>
            @endif
            
            @auth
                <!-- Кнопка добавления фильма (прячется в избранном, чтобы не мешать) -->
                @if(!request()->routeIs('favorites.index'))
                    <div class="mb-6 flex justify-end">
                        <a href="{{ route('movies.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition shadow-md">
                            + Добавить новый фильм
                        </a>
                    </div>
                @endif
            @endauth

            @if(request('search'))
                <div class="mb-6 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg flex justify-between items-center">
                    <div>
                        Результаты поиска по запросу: <span class="font-semibold text-gray-900 dark:text-white">"{{ request('search') }}"</span>
                        <span class="text-gray-500 ml-2">({{ count($movies) }} {{ trans_choice('найден|найдено|найдено', count($movies)) }})</span>
                    </div>
                    <a href="{{ route('movies.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-1">
                        ✕ Сбросить поиск
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($movies as $movie)
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-md sm:rounded-lg p-6 flex flex-col justify-between hover:shadow-xl transition-all duration-200">
                        <div>
                            @if($movie->poster)
                                <div class="w-full bg-gray-200/50 dark:bg-gray-900/50 rounded-md mb-4 flex justify-center items-center overflow-hidden relative group">
                                    <img src="/{{ $movie->poster }}" alt="{{ $movie->title }}" class="max-h-96 w-auto object-contain rounded-md shadow-md">
                                    
                                    @auth
                                        <form action="{{ route('favorites.toggle', $movie->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                            @csrf
                                            <button type="submit" class="p-2 bg-white/80 dark:bg-gray-900/80 hover:bg-white dark:hover:bg-gray-900 rounded-full transition-all duration-150 transform hover:scale-110 shadow-lg cursor-pointer">
                                                @if($movie->isFavoritedBy(Auth::user()))
                                                    <span class="text-red-500 text-lg">❤️</span>
                                                @else
                                                    <span class="text-gray-400 hover:text-red-400 text-lg">🤍</span>
                                                @endif
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            @endif
                            <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-1">{{ $movie->title }}</h3>
                            
                            <div class="flex items-center gap-1 mb-3">
                                @if($movie->reviews->count() > 0)
                                    <span class="text-yellow-500 font-bold text-sm">⭐ {{ round($movie->reviews->avg('rating'), 1) }}</span>
                                    <span class="text-gray-500 text-xs">({{ $movie->reviews->count() }})</span>
                                @else
                                    <span class="text-gray-400 text-xs">Нет оценок</span>
                                @endif
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 leading-relaxed">{{ $movie->description }}</p>
                        </div>
                        <div class="mt-6 flex gap-2">
                            <a href="{{ route('movies.show', $movie->id) }}" class="flex-1 text-center inline-flex justify-center items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition">
                                Подробнее
                            </a>

                            @auth
                                @if(Auth::user()->is_admin || Auth::id() === $movie->user_id)
                                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите навсегда удалить фильм «{{ $movie->title }}» и все отзывы к нему?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-md transition cursor-pointer" title="Удалить фильм">
                                            🗑️
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-400">
                        Ничего не найдено.
                    </div>
                @endforelse
            </div>

            @if(method_exists($movies, 'hasPages') && $movies->hasPages())
                <div class="mt-8">
                    {{ $movies->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
