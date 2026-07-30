@extends('layouts.app')

@section('title', 'Настройки профиля | КиноКаталог')
@section('header', 'Настройки профиля')

@section('content')
    <!-- Главный адаптивный контейнер -->
    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- БЛОК 1: Изменение имени и Email -->
            <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow sm:rounded-lg transition-colors duration-200">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Информация профиля</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Обновите имя учётной записи вашего аккаунта и адрес электронной почты.</p>
                    
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ваше имя</label>
                            <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email адрес</label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-md transition">
                            Сохранить изменения
                        </button>
                    </form>
                </div>
            </div>

            <!-- БЛОК 2: Смена пароля аккаунта -->
            <div class="p-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow sm:rounded-lg transition-colors duration-200">
                <div class="max-w-xl">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Обновление пароля</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Убедитесь, что ваша учётная запись использует надёжный и сложный пароль.</p>
                    
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                        @csrf
                        @method('put')

                        <div>
                            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Текущий пароль</label>
                            <input type="password" id="update_password_current_password" name="current_password" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="update_password_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Новый пароль</label>
                            <input type="password" id="update_password_password" name="password" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div>
                            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Повторите пароль</label>
                            <input type="password" id="update_password_password_confirmation" name="password_confirmation" class="mt-1 block w-full rounded-md bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md font-semibold text-xs uppercase tracking-widest shadow-md transition">
                            Обновить пароль
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
