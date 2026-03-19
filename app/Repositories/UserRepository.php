<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function getAll()
    {
        return User::with(['roles', 'branch'])
            ->select('users.*');
    }

    public function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make(123456789),
            'branch_id' => $data['branch_id'] ?? null
        ]);

        $user->syncRoles([$data['role']]);

        return $user;
    }

    public function update($id, array $data)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'branch_id' => $data['branch_id'] ?? null
        ]);

        if (!empty($data['password'])) {
            $user->update([
                'password' => Hash::make($data['password'])
            ]);
        }

        $user->syncRoles([$data['role']]);

        return $user;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }
}
