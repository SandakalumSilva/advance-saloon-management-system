<?php

namespace App\Repositories;

use App\Interfaces\ProductCategoryInterface;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

class ProductCategoryRepository implements ProductCategoryInterface
{
    public function getAll(): Collection
    {
        return ProductCategory::with('branch')->latest()->get();
    }

    public function create(array $data): ProductCategory
    {
        return ProductCategory::create([
            'branch_id' => $data['branch_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
        ]);
    }

    public function update(ProductCategory $productCategory, array $data): bool
    {
        return $productCategory->update([
            'branch_id' => $data['branch_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
        ]);
    }

    public function delete(ProductCategory $productCategory): bool
    {
        return $productCategory->delete();
    }
}
