<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Личный кабинет') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-200 space-y-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">👋</span>
                        <div>
                            <h3 class="font-bold text-lg text-white">Рады видеть вас снова, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-400 text-sm">Вы успешно авторизовались в системе каталога фильмов.</p>
                        </div>
                    </div>
                    
                    <hr class="border-gray-700 my-4">

                    <div>
                        <p class="text-gray-400 text-sm mb-3">Хотите выбрать фильм и почитать отзывы? Перейдите в наш каталог:</p>
                        <a href="{{ route('movies.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-md">
                            Перейти в каталог фильмов 🎬
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
