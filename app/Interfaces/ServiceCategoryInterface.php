<?php

namespace App\Interfaces;

use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;

interface ServiceCategoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): ServiceCategory;

    public function update(ServiceCategory $serviceCategory, array $data): bool;

    public function delete(ServiceCategory $serviceCategory): bool;
}