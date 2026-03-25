<?php

namespace App\Repositories;

use App\Interfaces\ServiceCategoryInterface;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceCategoryRepository implements ServiceCategoryInterface
{
    public function getAll(): Collection
    {
        return ServiceCategory::with('branch')
            ->branchFilter()
            ->latest()
            ->get();
    }

    public function create(array $data): ServiceCategory
    {
        return DB::transaction(function () use ($data) {

            $user = Auth::user();

            // $branchId = $data['branch_id'] ?? null;
            $branchId = $user->branch_id;

            return ServiceCategory::create([
                'branch_id'   => $branchId,
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ]);
        });
    }

    public function update(ServiceCategory $serviceCategory, array $data): bool
    {
        return DB::transaction(function () use ($serviceCategory, $data) {

            $user = Auth::user();

            $updateData = [
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ];

            return $serviceCategory->update($updateData);
        });
    }

    public function delete(ServiceCategory $serviceCategory): bool
    {
        return DB::transaction(function () use ($serviceCategory) {
            return $serviceCategory->delete();
        });
    }
}
