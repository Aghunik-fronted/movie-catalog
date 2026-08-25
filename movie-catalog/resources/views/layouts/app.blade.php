<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($title) {{ $title }} | @endisset {{ config('app.name', 'КиноКаталог') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://bunny.net">
        <link href="https://bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Проверка темы при старте страницы до рендеринга (защита от белой вспышки) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @hasSection('header')
                <header class="bg-white dark:bg-gray-800 shadow border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                            @yield('header')
                        </h2>
                    </div>
                </header>
            @endif

            <main>
                @yield('content')
            </main>
        </div>

        <!-- АВТОНОМНЫЙ СКРИПТ: Управляет переключением темы напрямую -->
        <script>
            function applyTheme(theme) {
                const sunIcon = document.getElementById('theme-toggle-sun');
                const moonIcon = document.getElementById('theme-toggle-moon');

                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    if (sunIcon) sunIcon.classList.remove('hidden');
                    if (moonIcon) moonIcon.classList.add('hidden');
                } else {
                    document.documentElement.classList.remove('dark');
                    if (sunIcon) sunIcon.classList.add('hidden');
                    if (moonIcon) moonIcon.classList.remove('hidden');
                }
            }

            function toggleMyTheme() {
                let currentTheme = localStorage.getItem('theme') || 'light';
                let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                localStorage.setItem('theme', newTheme);
                applyTheme(newTheme);
            }

            // Инициализация иконок после полной загрузки DOM
            document.addEventListener('DOMContentLoaded', () => {
                let savedTheme = localStorage.getItem('theme') || 'light';
                applyTheme(savedTheme);
            });
        </script>
    </body>
</html>
