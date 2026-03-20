<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function getAll();
    public function create(array $data);
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}
