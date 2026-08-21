@extends('layouts.app')

@section('title', 'Админ-панель | КиноКаталог')
@section('header', 'Панель администратора: Пользователи')

@section('content')
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('movies.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-150 group">
                    <span class="transform group-hover:-translate-x-1 transition duration-150">←</span> 
                    <span>Назад в каталог фильмов</span>
                </a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 dark:bg-green-950/50 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-md transition-colors duration-200">
                <div class="p-6 text-gray-900 dark:text-white">
                    <h3 class="font-bold text-xl mb-6 text-gray-900 dark:text-white">Список зарегистрированных пользователей</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 uppercase text-xs">
                                    <th class="p-4">Имя</th>
                                    <th class="p-4">Email</th>
                                    <th class="p-4">Статус</th>
                                    <th class="p-4">Причина блокировки</th>
                                    <th class="p-4 text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="p-4 font-medium text-gray-900 dark:text-white">{{ $user->name }}</td>
                                        <td class="p-4 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                        <td class="p-4">
                                            @if($user->is_blocked)
                                                <span class="px-2 py-1 bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-md text-xs font-semibold">Заблокирован</span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 dark:bg-green-950 text-green-700 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-md text-xs font-semibold">Активен</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-gray-500 dark:text-gray-400 italic">
                                            {{ $user->block_reason ?? '—' }}
                                        </td>
                                        <td class="p-4 text-right space-y-2 md:space-y-0 md:space-x-2 flex flex-col md:flex-row justify-end items-center">
                                            
                                            {{-- Форма Блокировки / Разблокировки --}}
                                            @if($user->is_blocked)
                                                <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs font-medium transition cursor-pointer">
                                                        Разблокировать
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="flex gap-2 items-center">
                                                    @csrf
                                                    <input type="text" name="block_reason" placeholder="Причина..." class="px-2 py-1 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-xs text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:border-indigo-500" required>
                                                    <button type="submit" class="px-3 py-1.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md text-xs font-medium transition cursor-pointer">
                                                        Заблокировать
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Форма полного удаления пользователя --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите НАВСЕГДА удалить пользователя {{ $user->name }} и все его отзывы?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-medium transition cursor-pointer">
                                                    Удалить
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-gray-400 dark:text-gray-500">Других пользователей в системе пока нет.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
