<?php

namespace App\Interfaces;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Collection;

interface ProductCategoryInterface
{
    public function getAll(): Collection;

    public function create(array $data): ProductCategory;

    public function update(ProductCategory $productCategory, array $data): bool;

    public function delete(ProductCategory $productCategory): bool;
}