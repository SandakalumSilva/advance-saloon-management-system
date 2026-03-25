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

            $user = Auth::user();
            $branchId = $user->branch_id;

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

            $updateData = [
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'branch_id' => $productCategory->branch_id ?? null,
                'status'      => $data['status'],
            ];

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
