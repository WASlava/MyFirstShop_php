<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string|max:255',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Створення користувача
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Призначення ролі
            $user->assignRole('User');

            // Додаткові дані для інформації про користувача
            $user->info()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.create')->with('error', 'Error occurred while creating user: ' . $e->getMessage());
        }
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

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string|max:255',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'password' => 'nullable|string|confirmed|min:8',
        ]);

        DB::beginTransaction();
        try {
            // Оновлення даних користувача
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            // Оновлення додаткової інформації
            $user->info()->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('users.edit', $user->id)->with('error', 'Error occurred while updating user: ' . $e->getMessage());
        }
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

        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

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
            dd($request);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Оновлення ролі
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Role updated successfully');
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


}
