<?php

namespace App\Interfaces;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

interface ServiceInterface
{
    public function getAll(): Collection;

    public function create(array $data): Service;

    public function update(Service $service, array $data): bool;

    public function delete(Service $service): bool;
}