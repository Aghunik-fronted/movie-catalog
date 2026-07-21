<x-app-layout>
    <x-slot name="header">
        <!-- Текст названия фильма в шапке всегда ярко-белый -->
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $movie->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Информация о фильме -->
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-6">
                @if($movie->poster)
                    <img src="/{{ $movie->poster }}" alt="{{ $movie->title }}" class="w-full md:w-64 h-auto object-contain rounded-md shadow-lg">
                @endif
                <div>
                    <h3 class="font-bold text-2xl text-white mb-4">{{ $movie->title }}</h3>
                    <p class="text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                </div>
            </div>

            <!-- Форма отправки отзыва (только для авторизованных) -->
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="font-bold text-lg text-white mb-4">Оставить отзыв</h4>
                
                @auth
                    @if(session('success'))
                        <div class="mb-4 text-sm font-medium text-green-400 bg-green-950/50 border border-green-800 p-3 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('reviews.store', $movie->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Ваша оценка</label>
                            <div class="flex flex-row-reverse justify-end items-center gap-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}" class="text-3xl text-gray-600 cursor-pointer hover:text-yellow-400 peer-hover:text-yellow-400 peer-checked:text-yellow-400 transition-colors duration-150">★</label>
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-300">Ваш отзыв</label>
                            <textarea id="content" name="content" rows="4" class="mt-1 block w-full rounded-md bg-gray-900 border-gray-700 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500" placeholder="Напишите ваше мнение о фильме..." required></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-md">
                            Отправить отзыв
                        </button>
                    </form>
                @else
                    <p class="text-gray-400 text-sm">
                        Чтобы оставить отзыв, пожалуйста, <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 underline">войдите в аккаунт</a> или <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 underline">зарегистрируйтесь</a>.
                    </p>
                @endauth
            </div>

            <!-- Список отзывов -->
            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="font-bold text-lg text-white mb-4">Отзывы пользователей</h4>
                <div class="space-y-4">
                    @forelse($movie->reviews as $review)
                        <div class="border-b border-gray-700 pb-4 last:border-0 last:pb-0">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-semibold text-gray-200">{{ $review->user->name }}</span>
                                <span class="text-yellow-400 font-bold tracking-wider">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </div>
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $review->content }}</p>
                            <span class="text-xs text-gray-500 block mt-1">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-4">К этому фильму ещё не оставили ни одного отзыва. Будьте первым!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
