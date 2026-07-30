@extends('layouts.app')

<!-- Передаем заголовок вкладки браузера через секцию -->
@section('title', 'Личный кабинет | КиноКаталог')

<!-- Передаем текст в верхнюю шапку сайта через секцию -->
@section('header', __('Личный кабинет'))

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-200">
                <div class="p-6 space-y-4">
                    
                    <!-- Блок приветствия авторизованного пользователя -->
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">👋</span>
                        <div>
                            <h3 class="font-bold text-lg text-gray-950 dark:text-white transition-colors duration-200">Рады видеть вас снова, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm transition-colors duration-200">Вы успешно авторизовались в системе каталога фильмов.</p>
                        </div>
                    </div>
                    
                    <hr class="border-gray-200 dark:border-gray-700 transition-colors duration-200">

                    <!-- Кнопка быстрого перехода к фильмам -->
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-3 transition-colors duration-200">Хотите выбрать фильм, посмотреть оценки или оставить свой отзыв?</p>
                        <a href="{{ route('movies.index') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-md">
                            Перейти в каталог фильмов 🎬
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

