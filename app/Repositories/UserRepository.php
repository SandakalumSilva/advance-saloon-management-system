<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{
    public function getAll()
    {
        return User::with(['roles', 'branch'])
            ->select('users.*')->latest();
    }

    public function create(array $data)
    {
        $plainPassword = Str::random(10);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            // 'phone' => $data['phone'],
            'password' => Hash::make($plainPassword),
            'branch_id' => $data['branch_id'] ?? null
        ]);

        $user->syncRoles([$data['role']]);

        $user->plain_password = $plainPassword;

        return $user;
    }

    public function update(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'branch_id' => $data['branch_id'] ?? null,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        if (!empty($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return $user->refresh();
    }

    public function delete(User $user): bool
    {
        if (Auth::id() === $user->id) {
            throw new \DomainException('You cannot delete your own account.');
        }

        return $user->delete();
    }
}
