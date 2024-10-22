<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Services\RoleManager;
use App\Http\Services\UserManager;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $userManager;
    protected $roleManager;

    public function __construct(UserManager $userManager, RoleManager $roleManager)
    {
        $this->userManager = $userManager;
        $this->roleManager = $roleManager;
    }

    public function index()
    {
        $roles = $this->roleManager->all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);

        $this->roleManager->create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = $this->roleManager->find($id);
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:roles,name,' . $id]);

        $role = $this->roleManager->find($id);
        $this->roleManager->update($role, $request->all());

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        // Знаходимо роль
        $role = $this->roleManager->find($id);

        // Перевіряємо, чи є користувачі з цією роллю
        $usersWithRole = User::role($role->name)->count();

        if ($usersWithRole > 0) {
            return redirect()->route('roles.index')->with('error', 'Неможливо видалити роль, оскільки вона призначена користувачам.');
        }

        // Якщо користувачів з цією роллю немає, видаляємо роль
        $this->roleManager->delete($role);

        return redirect()->route('roles.index')->with('success', 'Роль успішно видалено.');
    }

    public function assignRole(Request $request, $userId)
    {
        $user = $this->userManager->find($userId);
        $role = $request->input('role');

        $this->userManager->assignRoles($user, [$role]);

        return redirect()->route('users.index')->with('success', 'Role assigned successfully.');
    }

    public function removeRole(Request $request, $userId)
    {
        $user = $this->userManager->find($userId);
        $role = $request->input('role');

        $this->userManager->removeRoles($user, [$role]);

        return redirect()->route('users.index')->with('success', 'Role removed successfully.');
    }

    public function changeRole(Request $request, $id)
    {
        // Знайти користувача за ID
        $user = User::findOrFail($id);

        // Отримати нову роль з форми
        $newRole = $request->input('role');

        // Перевірити, чи роль існує
        if (!Role::where('name', $newRole)->exists()) {
            return redirect()->back()->with('error', 'Role does not exist.');
        }

        // Видалити всі ролі користувача
        $user->roles()->detach();

        // Призначити нову роль
        $user->assignRole($newRole);

        return redirect()->route('users.index')->with('success', 'Role changed successfully!');
    }
}
