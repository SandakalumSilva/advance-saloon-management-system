<?php

namespace App\Repositories;

use App\Interfaces\ServiceCategoryInterface;
use App\Models\ServiceCategory;
use Illuminate\Database\Eloquent\Collection;

class ServiceCategoryRepository implements ServiceCategoryInterface
{
    public function getAll(): Collection
    {
        return ServiceCategory::with('branch')->latest()->get();
    }

    public function create(array $data): ServiceCategory
    {
        return ServiceCategory::create([
            'branch_id' => $data['branch_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
        ]);
    }
    public function update(ServiceCategory $serviceCategory, array $data): bool
    {
        return $serviceCategory->update([
            'branch_id' => $data['branch_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
        ]);
    }

    public function delete(ServiceCategory $serviceCategory): bool
    {
        return $serviceCategory->delete();
    }
}
