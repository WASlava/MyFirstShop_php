<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManager
{
    public function create(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']); // Хешування пароля
        $user->save();

        return $user;
    }

    public function find($id): ?User
    {
        return User::find($id);
    }

    public function getUserRoles(User $user): array
    {
        return $user->roles()->pluck('name')->toArray();
    }

    public function addRoles(User $user, array $roles): void
    {
        $user->assignRole($roles);
    }

    public function removeRoles(User $user, array $roles): void
    {
        $user->removeRole($roles);
    }

    public function assignRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }
}
