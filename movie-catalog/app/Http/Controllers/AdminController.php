<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Главная страница админки: список всех пользователей, кроме текущего админа.
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $title = 'Панель администратора';
        $header = 'Управление пользователями';

        return view('admin.index', compact('users', 'title', 'header'));
    }

    /**
     * Блокировка пользователя с указанием причины.
     */
    public function block(Request $request, User $user)
    {
        $request->validate([
            'block_reason' => 'required|string|min:3'
        ]);

        $user->update([
            'is_blocked' => true,
            'block_reason' => $request->block_reason
        ]);

        return redirect()->back()->with('success', "Пользователь {$user->name} успешно заблокирован.");
    }

    /**
     * Разблокировка пользователя.
     */
    public function unblock(User $user)
    {
        $user->update([
            'is_blocked' => false,
            'block_reason' => null
        ]);

        return redirect()->back()->with('success', "Пользователь {$user->name} разблокирован.");
    }

    /**
     * Полное удаление пользователя из системы.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', "Пользователь {$user->name} полностью удален из системы.");
    }

    public function dashboard()
    {
        return view('admin.dashboard'); 
    }
}