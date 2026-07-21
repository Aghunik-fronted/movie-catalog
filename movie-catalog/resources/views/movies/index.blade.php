<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Каталог фильмов') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($movies as $movie)
                    <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-md sm:rounded-lg p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-200">
                        <div>
                            @if($movie->poster)
                                <div class="w-full bg-gray-900/50 rounded-md mb-4 flex justify-center items-center overflow-hidden">
                                    <img src="/{{ $movie->poster }}" alt="{{ $movie->title }}" class="max-h-96 w-auto object-contain rounded-md shadow-md">
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
                    <div class="col-span-3 bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-500">
                        Фильмов пока нет в каталоге.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
