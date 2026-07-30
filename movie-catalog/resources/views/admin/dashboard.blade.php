@extends('layouts.app')

@section('title', 'Панель управления | Администратор')
@section('header', 'Центр управления системой (Admin)')

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Приветственная карточка Admin Premium -->
            <div class="bg-gradient-to-r from-indigo-800 to-slate-900 rounded-2xl shadow-xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="text-3xl animate-bounce">👑</span>
                            <h3 class="font-black text-2xl tracking-wide">Приветствую, {{ Auth::user()->name }}!</h3>
                        </div>
                        <p class="text-indigo-200 text-sm max-w-xl">Добро пожаловать в защищенный центр управления КиноКаталогом. Здесь вы можете модерировать пользователей, управлять медиатекой и следить за платформой.</p>
                    </div>
                    <a href="{{ route('movies.index') }}" class="inline-flex items-center px-5 py-3 bg-white text-indigo-900 hover:bg-gray-100 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg transition transform hover:scale-105">
                        Открыть каталог фильмов 🎬
                    </a>
                </div>
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-700/20 rounded-full blur-2xl"></div>
            </div>

            <!-- Блок живой статистики -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Карточка 1: Фильмы -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-md transition hover:shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Медиатека</p>
                        <h4 class="text-3xl font-black text-gray-900 dark:text-white">9 уникальных</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">фильмов загружено в базу</p>
                    </div>
                    <span class="text-4xl bg-indigo-50 dark:bg-indigo-950/50 p-3 rounded-xl">🎥</span>
                </div>

                <!-- Карточка 2: Community -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-md transition hover:shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Сообщество</p>
                        <h4 class="text-3xl font-black text-gray-900 dark:text-white">Активные</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">пользователи платформы</p>
                    </div>
                    <span class="text-4xl bg-green-50 dark:bg-green-950/50 p-3 rounded-xl">👥</span>
                </div>

                <!-- Карточка 3: Роль -->
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-md transition hover:shadow-lg flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Статус сессии</p>
                        <h4 class="text-3xl font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest text-xl">Admin Panel</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">доступ ко всем правам открыт</p>
                    </div>
                    <span class="text-4xl bg-yellow-50 dark:bg-yellow-950/50 p-3 rounded-xl">🔒</span>
                </div>
            </div>
                        <!-- Панель быстрых административных действий -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-md p-6">
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Быстрые действия администратора</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Действие 1: Управление пользователями -->
                    <a href="{{ route('admin.users.index') }}" class="p-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 rounded-xl flex items-center gap-4 transition-all duration-200 group">
                        <span class="text-2xl bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">⚙️</span>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-indigo-500 transition-colors">Модерация пользователей</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Блокировка, разблокировка и полное удаление аккаунтов.</p>
                        </div>
                    </a>

                    <!-- Действие 2: Добавить новый фильм -->
                    <a href="{{ route('movies.create') }}" class="p-4 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-500 rounded-xl flex items-center gap-4 transition-all duration-200 group">
                        <span class="text-2xl bg-white dark:bg-gray-800 p-2 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">➕</span>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-green-500 transition-colors">Добавить новый фильм</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Заполнение формы, описание сюжета и загрузка `.webp` обложки.</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
@endsection

