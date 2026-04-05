<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class UserRepository implements UserInterface
{
    public function getQuery(?string $search = null): Builder
    {
        return User::query()
            ->with(['roles', 'branch', 'staff'])
            ->select('users.*')
            ->branchFilter()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('users.phone', 'like', "%{$search}%")
                        ->orWhereHas('roles', function ($roleQuery) use ($search) {
                            $roleQuery->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('staff', function ($staffQuery) use ($search) {
                            $staffQuery->where('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest('users.id');
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $authUser = Auth::user();

            $plainPassword = Str::random(10);

            $branchId = $data['branch_id'] ?? null;

            if ($authUser instanceof User && ! $authUser->isSuperAdmin()) {
                $branchId = $authUser->branch_id;
            }

            $photoPath = null;

            if (!empty($data['photo'])) {
                $photoPath = $data['photo']->store('staff', 'public');
            }

            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => Hash::make($plainPassword),
                'branch_id' => $branchId,
            ]);

            $user->syncRoles([$data['role']]);

            Staff::create([
                'user_id'       => $user->id,
                'branch_id'     => $branchId,
                'phone'         => $data['phone'] ?? null,
                'gender'        => $data['gender'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'address'       => $data['address'] ?? null,
                'join_date'     => $data['join_date'] ?? null,
                'basic_salary'  => $data['basic_salary'] ?? null,
                'photo'         => $photoPath,
                'status'        => $data['status'] ?? true,
            ]);

            $user->plain_password = $plainPassword;

            return $user->load(['roles', 'branch', 'staff']);
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $authUser = Auth::user();

            $branchId = $user->branch_id;

            if ($authUser instanceof User && $authUser->isSuperAdmin()) {
                $branchId = $data['branch_id'] ?? $user->branch_id;
            }

            $user->update([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'branch_id' => $branchId,
                'password'  => !empty($data['password'])
                    ? Hash::make($data['password'])
                    : $user->password,
            ]);

            if (!empty($data['role'])) {
                $user->syncRoles([$data['role']]);
            }

            $photoPath = $user->staff?->photo;

            if (!empty($data['photo'])) {
                $photoPath = $data['photo']->store('staff', 'public');
            }

            $user->staff()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'branch_id'     => $branchId,
                    'phone'         => $data['phone'] ?? null,
                    'gender'        => $data['gender'] ?? null,
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'address'       => $data['address'] ?? null,
                    'join_date'     => $data['join_date'] ?? null,
                    'basic_salary'  => $data['basic_salary'] ?? null,
                    'photo'         => $photoPath,
                    'status'        => $data['status'] ?? true,
                ]
            );

            return $user->refresh()->load(['roles', 'branch', 'staff']);
        });
    }

    public function delete(User $user): bool
    {
        if (Auth::id() === $user->id) {
            throw new \DomainException('You cannot delete your own account.');
        }

        return DB::transaction(function () use ($user) {
            $user->staff()?->delete();
            return $user->delete();
        });
    }
}
