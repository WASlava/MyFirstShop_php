<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    // Відображення списку користувачів
    public function index()
    {
        $users = User::with('info', 'roles')->get();
        return view('users.index', compact('users'));
    }

    // Форма для створення користувача
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Створення користувача
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Створення користувача
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Призначення ролі 'User' при створенні
        $user->assignRole('User');

        // Додаткові дані для інформації про користувача
        $user->info()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    // Форма для редагування користувача
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Оновлення користувача
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Валідація для інших полів, якщо потрібно
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Оновлення даних користувача
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Можливість змінювати пароль, якщо потрібно
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Оновлення ролі
        $user->syncRoles($request->role);

        // Оновлення додаткової інформації
        $user->info()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'telephone' => $request->telephone,
            'address' => $request->address,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function show($id)
    {
        $user = User::with('info', 'roles')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Видалення користувача
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

// Форма для зміни пароля (GET-запит)
    public function changePassword($id)
    {
        $user = User::findOrFail($id);
        return view('users.changePassword', compact('user'));
    }

// Оновлення пароля (PUT-запит)
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Password updated successfully');
    }


    // Форма для зміни ролі користувача
    public function changeRole($id)
    {
        $user = User::with('info', 'roles')->findOrFail($id);
        $roles = Role::all();
        return view('users.changeRole', compact('user', 'roles'));
    }

    // Оновлення ролі користувача
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Role updated successfully');
    }
}
