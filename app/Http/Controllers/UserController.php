<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('users.index', compact('users'));
    }
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'Вы не можете удалить свою собственную учетную запись.');
        }

        if ($user->role === 'admin') {
            $currentUser = auth()->user();
            
            if ($currentUser->email !== 'admin@estate.local') {
                return redirect()->route('users.index')
                    ->with('error', 'У вас нет прав на удаление администратора.');
            }
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Пользователь "' . $user->name . '" успешно удален.');
    }
    public function create()
    {
        $roles = ['admin' => 'Администратор', 
        'employee' => 'Сотрудник'];

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,employee'],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь успешно создан.');
    }
}
