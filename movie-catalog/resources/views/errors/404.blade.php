<!DOCTYPE html>
<html lang="ru" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница не найдена — 404</title>
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/build/assets/app.css">
    @endif
</head>
<body class="bg-gray-950 text-white flex flex-col items-center justify-center min-h-screen p-4 select-none antialiased">

    <div class="text-center max-w-md mx-auto">
        <!-- Большая стильная иконка ошибки с тенью Tailwind -->
        <div class="text-8xl mb-6 tracking-wide drop-shadow-[0_10px_10px_rgba(99,102,241,0.3)] animate-pulse">
            🎬<span class="text-red-500 font-light">🍿</span>
        </div>
        
        <!-- Заголовок ошибки 404 с вашим фирменным Tailwind-градиентом -->
        <h1 class="text-6xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 uppercase tracking-wider mb-3">
            Ошибка 404
        </h1>
        
        <!-- Подзаголовок страницы -->
        <h2 class="text-2xl font-bold text-gray-200 mb-2">
            Кадр не найден!
        </h2>
        
        <!-- Описание ошибки -->
        <p class="text-sm text-gray-400 mb-8 leading-relaxed px-4">
            Упс! Такой страницы, отзыва или фильма ещё не существует в нашей базе данных. Возможно, адрес был введён с опечаткой.
        </p>

        <!-- Кнопка возврата на рабочий каталог фильмов на чистом Tailwind -->
        <a href="/movies" class="inline-flex items-center gap-2 bg-gradient-to-tr from-indigo-500 to-cyan-400 hover:from-indigo-600 hover:to-cyan-500 text-white font-bold px-6 py-3.5 rounded-xl shadow-[0_4px_20px_rgba(99,102,241,0.4)] transform hover:scale-105 active:scale-95 transition duration-150 cursor-pointer">
            <span>🍿</span> Вернуться в каталог
        </a>
    </div>

</body>
</html>
