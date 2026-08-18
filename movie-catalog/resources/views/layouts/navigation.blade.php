<nav x-data="{ open: false }" class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex flex-1">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::check() && Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-2">
                        <span class="text-2xl">🎬</span> 
                        <span class="font-black text-xl tracking-wider bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent uppercase">
                            Movie<span class="text-white">Catalog</span>
                        </span>
                    </a>
                </div>

                <!-- Links (ПК) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <a href="{{ route('movies.index') }}" class="text-white hover:text-gray-300 font-semibold h-16 flex items-center">
                        Фильмы
                    </a>
                    @auth
                        <a href="{{ route('favorites.index') }}" class="text-white hover:text-gray-300 font-semibold h-16 flex items-center">
                            ❤️ Избранное
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.users.index') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold h-16 flex items-center">
                                ⚙️ Панель управления
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Поиск (ПК) -->
                <div class="hidden sm:flex sm:items-center flex-1 max-w-xs ms-6">
                    <form action="{{ route('movies.index') }}" method="GET" class="relative w-full">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Найти фильм..." class="block w-full pl-4 pr-8 py-1.5 text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none">
                    </form>
                </div>
            </div>

            <!-- Правая сторона (ПК) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <button onclick="toggleMyTheme()" class="mr-4 p-2 text-gray-400 hover:bg-gray-700 focus:outline-none rounded-lg text-sm transition duration-150 cursor-pointer">
                    <svg id="theme-toggle-sun" class="hidden w-5 h-5 fill-current text-yellow-400" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 2.293a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zm2.707 5.707a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-2.293 4a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM11 17a1 1 0 10-2 0v1a1 1 0 102 0v-1zm-4-2.293a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM3 9a1 1 0 100 2h1a1 1 0 100-2h-1zm2.293-4.707a1 1 0 010 1.414L4.586 6.414A1 1 0 013.172 5l.707-.707a1 1 0 011.414 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                    <svg id="theme-toggle-moon" class="hidden w-5 h-5 fill-current text-indigo-400" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 border border-transparent text-sm font-medium rounded-full text-gray-300 hover:text-white focus:outline-none transition duration-150">
                            @auth
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm shadow-md uppercase">{{ mb_substr(Auth::user()->name, 0, 1) }}</div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 font-bold text-sm shadow-md">👤</div>
                            @endauth
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @auth
                            <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-md">Авторизован: <span class="font-bold">{{ Auth::user()->name }}</span></div>
                            <x-dropdown-link :href="route('profile.edit')">Профиль</x-dropdown-link>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('login')">Войти</x-dropdown-link>
                            <x-dropdown-link :href="route('register')">Регистрация</x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Кнопка Мобильного Бургера -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
        <!-- Мобильное выезжающее меню бургера -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-900 border-t border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Мобильный Поиск -->
            <div class="px-4 py-2">
                <form action="{{ route('movies.index') }}" method="GET" class="relative w-full">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Найти фильм..." class="block w-full pl-4 pr-8 py-2 text-sm text-gray-200 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none">
                </form>
            </div>

            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')">
                🎬 Фильмы
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')">
                    ❤️ Избранное
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Настройки и профиль в мобильном меню -->
        <div class="pt-4 pb-1 border-t border-gray-800">
            <!-- Переключатель ТЕМЫ внутри шторки бургера -->
            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-800 pb-4 mb-2">
                <div class="text-sm font-medium text-gray-400">Сменить фон:</div>
                <button onclick="toggleMyTheme()" class="p-2 bg-gray-800 hover:bg-gray-700 rounded-xl text-sm text-gray-300">
                    🌓 Изменить тему
                </button>
            </div>

            @auth
                <!-- Данные авторизации Aghunik -->
                <div class="px-4 py-3 bg-gray-800/50 my-2 rounded-lg mx-2">
                    <div class="text-xs text-gray-500">Авторизован:</div>
                    <div class="text-base font-bold text-indigo-400">{{ Auth::user()->name }} @if(Auth::user()->is_admin) (Admin) @endif</div>
                    <div class="text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if(Auth::user()->is_admin)
                        <x-responsive-nav-link :href="route('admin.users.index')" class="text-indigo-400 font-bold">
                            ⚙️ Панель управления
                        </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('profile.edit')">
                        👤 Профиль
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400 cursor-pointer">
                            🚪 Выйти
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">Войти</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">Регистрация</x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>