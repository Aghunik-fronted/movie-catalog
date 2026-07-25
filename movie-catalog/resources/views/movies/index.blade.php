@php 
    $title = $title ?? 'Все фильмы'; 
@endphp

@extends('layouts.app')

<!-- Передаем заголовок вкладки браузера -->
@section('title', $title . ' | КиноКаталог')

<!-- Передаем текст в верхнюю шапку сайта (будет меняться на "Моё Избранное") -->
@section('header', $header ?? 'Каталог фильмов')

@section('content')
    @auth
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6 flex justify-end">
            <a href="{{ route('movies.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition shadow-md">
                + Добавить новый фильм
            </a>
        </div>
    @endauth

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- БЛОК СТАТУСА ПОИСКА (Показывается только при активном поиске) --}}
            @if(request('search'))
                <div class="mb-6 p-4 bg-gray-800 border border-gray-700 rounded-lg flex justify-between items-center text-gray-300">
                    <div>
                        Результаты поиска по запросу: <span class="font-semibold text-white">"{{ request('search') }}"</span>
                        {{-- Безопасно выводим количество, так как при обычном ->get() метода total() нет --}}
                        <span class="text-gray-500 ml-2">({{ count($movies) }} {{ trans_choice('найден|найдено|найдено', count($movies)) }})</span>
                    </div>
                    <a href="{{ route('movies.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300 hover:underline flex items-center gap-1">
                        ✕ Сбросить поиск
                    </a>
                </div>
            @endif

            {{-- СЕТКА ФИЛЬМОВ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($movies as $movie)
                    <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-md sm:rounded-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-200">
                        <div>
                            @if($movie->poster)
                                <!-- Контейнер для отображения картинок без обрезки макушек с поддержкой сердечка -->
                                <div class="w-full bg-gray-900/50 rounded-md mb-4 flex justify-center items-center overflow-hidden relative group">
                                    <img src="/{{ $movie->poster }}" alt="{{ $movie->title }}" class="max-h-96 w-auto object-contain rounded-md shadow-md">
                                    
                                    <!-- Кнопка Избранного (сердечко) поверх картинки -->
                                    @auth
                                        <form action="{{ route('favorites.toggle', $movie->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                            @csrf
                                            <button type="submit" class="p-2 bg-gray-900/80 hover:bg-gray-900 rounded-full transition-all duration-150 transform hover:scale-110 shadow-lg cursor-pointer">
                                                @if($movie->isFavoritedBy(Auth::user()))
                                                    <!-- Закрашенное красное сердечко, если фильм в избранном -->
                                                    <span class="text-red-500 text-lg">❤️</span>
                                                @else
                                                    <!-- Пустое сердечко, если фильма нет в избранном -->
                                                    <span class="text-gray-400 hover:text-red-400 text-lg">🤍</span>
                                                @endif
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            @endif
                            <h3 class="font-bold text-xl text-white mb-1">{{ $movie->title }}</h3>
                            
                            <div class="flex items-center gap-1 mb-3">
                                @if($movie->reviews->count() > 0)
                                    <span class="text-yellow-400 font-bold text-sm">⭐ {{ round($movie->reviews->avg('rating'), 1) }}</span>
                                    <span class="text-gray-500 text-xs">({{ $movie->reviews->count() }})</span>
                                @else
                                    <span class="text-gray-500 text-xs">Нет оценок</span>
                                @endif
                            </div>

                            <p class="text-gray-400 text-sm line-clamp-3 leading-relaxed">{{ $movie->description }}</p>
                        </div>
                        
                        <div class="mt-6">
                            <a href="{{ route('movies.show', $movie->id) }}" class="w-full justify-center inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                                Подробнее и отзывы
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-400">
                        @if(request('search'))
                            По запросу <span class="text-white font-semibold">"{{ request('search') }}"</span> ничего не найдено.
                        @else
                            Фильмов пока нет в каталоге.
                        @endif
                    </div>
                @endforelse
            </div>

            {{-- БЛОК ПАГИНАЦИИ (Выводится безопасно через проверку метода) --}}
            @if(method_exists($movies, 'hasPages') && $movies->hasPages())
                <div class="mt-8 dark-pagination">
                    {{ $movies->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
