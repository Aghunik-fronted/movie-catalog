<nav class="bg-gray-800 border-b border-gray-700">
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

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <a href="{{ route('movies.index') }}" class="text-white hover:text-gray-300 font-semibold h-16 flex items-center">
                        {{ __('Фильмы') }}
                    </a>

                    @auth
                        <a href="{{ route('favorites.index') }}" class="text-white hover:text-gray-300 font-semibold h-16 flex items-center">
                            {{ __('❤️ Избранное') }}
                        </a>
                    @endauth

                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.users.index') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold h-16 flex items-center">
                                {{ __('⚙️ Панель управления') }}
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Поле НАЙТИ -->
                <div class="hidden sm:flex sm:items-center flex-1 max-w-xs ms-6">
                    <form action="{{ route('movies.index') }}" method="GET" class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://w3.org">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Найти фильм..." class="block w-full pl-10 pr-8 py-1.5 text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none">
                        @if(request('search'))
                            <a href="{{ route('movies.index') }}" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-gray-400 hover:text-gray-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Правая сторона меню (Переключатель Темы + Выпадающий список) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Кнопка переключения темы -->
                <button onclick="toggleMyTheme()" class="mr-4 p-2 text-gray-400 hover:bg-gray-700 focus:outline-none rounded-lg text-sm transition duration-150 cursor-pointer">
                    <svg id="theme-toggle-sun" class="hidden w-5 h-5 fill-current text-yellow-400" viewBox="0 0 20 20" xmlns="http://w3.org"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 2.293a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zm2.707 5.707a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-2.293 4a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM11 17a1 1 0 10-2 0v1a1 1 0 102 0v-1zm-4-2.293a1 1 0 010 1.414l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 0zM3 9a1 1 0 100 2h1a1 1 0 100-2h-1zm2.293-4.707a1 1 0 010 1.414L4.586 6.414A1 1 0 013.172 5l.707-.707a1 1 0 011.414 0zM10 5a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                    <svg id="theme-toggle-moon" class="hidden w-5 h-5 fill-current text-indigo-400" viewBox="0 0 20 20" xmlns="http://w3.org"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 border border-transparent text-sm font-medium rounded-full text-gray-300 hover:text-white focus:outline-none transition duration-150 cursor-pointer">
                            @auth
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-cyan-400 flex items-center justify-center text-white font-bold text-sm shadow-md uppercase transform hover:scale-105 transition duration-150" title="{{ Auth::user()->name }}">
                                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-300 font-bold text-sm shadow-md" title="Гость">
                                    👤
                                </div>
                            @endauth
                        </button>
                    </x-slot>
                    <<x-slot name="content">
                        @auth
                            <!-- Чистая информационная плашка, которая сама адаптируется под тему -->
                            <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 rounded-t-md transition-colors duration-200">
                                {{ __('Авторизован:') }} <span class="font-bold">{{ Auth::user()->name }}</span>
                            </div>

                            <!-- Стандартные ссылки Breeze (они сами идеально меняют цвет с чёрного на белый) -->
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Профиль') }}
                            </x-dropdown-link>
                            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="cursor-pointer">
                                {{ __('Выйти') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Войти') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('Регистрация') }}
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (ИСПРАВЛЕНО: Кнопка бургера теперь переключает переменную open по клику) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-700 focus:outline-none transition duration-150 ease-in-out cursor-pointer">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" xmlns="http://w3.org">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (ИСПРАВЛЕНО: Убран фиксированный скрывающий класс hidden, мешавший раскрытию) -->
    <div x-show="open" @click.away="open = false" class="sm:hidden bg-gray-800 border-t border-gray-700 transition-all duration-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('movies.index')" :active="request()->routeIs('movies.index')" class="text-white block px-4 py-2 hover:bg-gray-700">
                {{ __('Фильмы') }}
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')" class="text-white block px-4 py-2 hover:bg-gray-700">
                    {{ __('❤️ Избранное') }}
                </x-responsive-nav-link>
            @endauth

            @auth
                @if(Auth::user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="text-indigo-400 block px-4 py-2 hover:bg-gray-700">
                        <span>⚙️ Панель управления</span>
                    </x-responsive-nav-link>
                @endif
            @endauth
            
            <!-- Мобильное поле поиска -->
            <div class="px-4 py-2">
                <form action="{{ route('movies.index') }}" method="GET" class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://w3.org">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Найти фильм..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none">
                </form>
            </div>
        </div>

        <!-- Информация об аккаунте и ссылки (Мобильные) -->
        <div class="pt-4 pb-1 border-t border-gray-700 bg-gray-900/50">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()?->name ?? 'Гость' }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()?->email ?? 'Авторизуйтесь для отзывов' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 block px-4 py-2 hover:bg-gray-700">
                        {{ __('Профиль') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-300 block px-4 py-2 hover:bg-gray-700">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('login')" class="text-gray-300 block px-4 py-2 hover:bg-gray-700">
                        {{ __('Войти') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="text-gray-300 block px-4 py-2 hover:bg-gray-700">
                        {{ __('Регистрация') }}
                    </x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>

