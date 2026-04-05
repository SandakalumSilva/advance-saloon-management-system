<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserInterface
{
    public function getQuery(?string $search = null): Builder;
    public function create(array $data);
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}
