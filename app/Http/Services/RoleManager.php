<?php

namespace App\Http\Services;

use Spatie\Permission\Models\Role;
use App\Models\User;


class RoleManager
{
    public function all()
    {
        return Role::all();
    }

    public function find($id): ?Role
    {
        return Role::find($id);
    }

    public function create(array $data): Role
    {
        $role = new Role();
        $role->name = $data['name'];
        $role->save();

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $role->name = $data['name'];
        $role->save();

        return $role;
    }

    public function delete(Role $role): void
    {
        $role->delete();
    }

    public function assignRole(User $user, string $roleName): void
    {
        $user->assignRole($roleName);
    }

    public function removeRole(User $user, string $roleName): void
    {
        $user->removeRole($roleName);
    }
}
