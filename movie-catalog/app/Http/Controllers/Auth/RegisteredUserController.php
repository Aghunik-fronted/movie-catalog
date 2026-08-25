<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Усиленная проверка email (валидация домена по RFC и DNS)
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
            // Жесткие требования к паролю ради максимальной надежности
            'password' => [
                'required', 
                'confirmed', 
                Rules\Password::min(8) // Не менее 8 символов
                    ->letters()        // Требовать буквы
                    ->mixedCase()      // Требовать заглавные и строчные буквы
                    ->numbers()        // Требовать цифры
                    ->symbols()        // Требовать спецсимволы (!, @, #, $, %)
            ],
        ], [
            'name.required' => 'Пожалуйста, введите ваше имя.',
            'email.required' => 'Поле email является обязательным для заполнения.',
            'email.email' => 'Пожалуйста, введите корректный и реально существующий адрес электронной почты.',
            'email.unique' => 'Этот email-адрес уже зарегистрирован в системе КиноКаталога.',
            'password.required' => 'Пожалуйста, задайте пароль для вашего аккаунта.',
            'password.confirmed' => 'Введённые пароли не совпадают.',
            'password' => 'Пароль слишком простой! Он должен содержать не менее 8 символов, включая заглавные и строчные буквы, цифры и спецсимволы (!, @, #, $, %).',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('movies.index', absolute: false));
    }
}
