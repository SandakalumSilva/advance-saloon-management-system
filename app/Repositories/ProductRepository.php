<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductInterface
{
    public function getAll(): Collection
    {
        return Product::with(['branch', 'category'])->latest()->get();
    }

    public function create(array $data): Product
    {
        return Product::create([
            'branch_id' => $data['branch_id'] ?? null,
            'product_category_id' => $data['product_category_id'],
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'selling_price' => $data['selling_price'],
            'cost_price' => $data['cost_price'] ?? null,
            'stock_qty' => $data['stock_qty'],
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
            'status' => $data['status'],
        ]);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update([
            'branch_id' => $data['branch_id'] ?? null,
            'product_category_id' => $data['product_category_id'],
            'name' => $data['name'],
            'sku' => $data['sku'] ?? null,
            'description' => $data['description'] ?? null,
            'selling_price' => $data['selling_price'],
            'cost_price' => $data['cost_price'] ?? null,
            'stock_qty' => $data['stock_qty'],
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
            'status' => $data['status'],
        ]);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }
}