<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface
{
    public function getAll(): Collection
    {
        return Product::with(['branch', 'category'])
            ->branchFilter()
            ->latest()
            ->get();
    }

    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
           
            $user = Auth::user();

            $branchId = $data['branch_id'] ?? null;

            if ($user instanceof User && ! $user->isSuperAdmin()) {
                $branchId = $user->branch_id;

                // Validate category belongs to same branch
                $validCategory = ProductCategory::query()
                    ->where('id', $data['product_category_id'])
                    ->where('branch_id', $user->branch_id)
                    ->exists();

                abort_unless($validCategory, 403, 'Invalid product category for this branch.');
            }

            return Product::create([
                'branch_id'            => $branchId,
                'product_category_id'  => $data['product_category_id'],
                'name'                 => $data['name'],
                'sku'                  => $data['sku'] ?? null,
                'description'          => $data['description'] ?? null,
                'selling_price'        => $data['selling_price'],
                'cost_price'           => $data['cost_price'] ?? null,
                'stock_qty'            => $data['stock_qty'],
                'commission_type'      => $data['commission_type'],
                'commission_value'     => $data['commission_value'],
                'status'               => $data['status'],
            ]);
        });
    }

    public function update(Product $product, array $data): bool
    {
        return DB::transaction(function () use ($product, $data) {
            
            $user = Auth::user();

            if ($user instanceof User && ! $user->isSuperAdmin()) {
                // Validate category belongs to same branch
                $validCategory = ProductCategory::query()
                    ->where('id', $data['product_category_id'])
                    ->where('branch_id', $user->branch_id)
                    ->exists();

                abort_unless($validCategory, 403, 'Invalid product category for this branch.');
            }

            $updateData = [
                'product_category_id'  => $data['product_category_id'],
                'name'                 => $data['name'],
                'sku'                  => $data['sku'] ?? null,
                'description'          => $data['description'] ?? null,
                'selling_price'        => $data['selling_price'],
                'cost_price'           => $data['cost_price'] ?? null,
                'stock_qty'            => $data['stock_qty'],
                'commission_type'      => $data['commission_type'],
                'commission_value'     => $data['commission_value'],
                'status'               => $data['status'],
            ];
            
            return $product->update($updateData);
        });
    }

    public function delete(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            return $product->delete();
        });
    }
}
