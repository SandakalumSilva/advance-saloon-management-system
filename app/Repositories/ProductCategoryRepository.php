<?php

namespace App\Repositories;

use App\Interfaces\ProductCategoryInterface;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductCategoryRepository implements ProductCategoryInterface
{
    public function getAll(): Collection
    {
        return ProductCategory::with('branch')
            ->branchFilter()
            ->latest()
            ->get();
    }

    public function create(array $data): ProductCategory
    {
        return DB::transaction(function () use ($data) {
            /** @var User|null $user */
            $user = Auth::user();

            $branchId = $data['branch_id'] ?? null;

            // Force branch for non-super-admin
            if ($user instanceof User && ! $user->isSuperAdmin()) {
                $branchId = $user->branch_id;
            }

            return ProductCategory::create([
                'branch_id'   => $branchId,
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ]);
        });
    }

    public function update(ProductCategory $productCategory, array $data): bool
    {
        return DB::transaction(function () use ($productCategory, $data) {
            /** @var User|null $user */
            $user = Auth::user();

            $updateData = [
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'status'      => $data['status'],
            ];

            // Only super admin can change branch
            if ($user instanceof User && $user->isSuperAdmin()) {
                $updateData['branch_id'] = $data['branch_id'] ?? $productCategory->branch_id;
            }

            return $productCategory->update($updateData);
        });
    }

    public function delete(ProductCategory $productCategory): bool
    {
        return DB::transaction(function () use ($productCategory) {
            return $productCategory->delete();
        });
    }
}