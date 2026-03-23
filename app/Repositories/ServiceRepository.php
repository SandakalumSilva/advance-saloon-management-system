<?php

namespace App\Repositories;

use App\Interfaces\ServiceInterface;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository implements ServiceInterface
{
    public function getAll(): Collection
    {
        return Service::with(['branch', 'category'])->latest()->get();
    }

    public function create(array $data): Service
    {
        return Service::create([
            'branch_id' => $data['branch_id'] ?? null,
            'service_category_id' => $data['service_category_id'],
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'description' => $data['description'] ?? null,
            'duration_minutes' => $data['duration_minutes'],
            'price' => $data['price'],
            'cost' => $data['cost'] ?? null,
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
            'status' => $data['status'],
        ]);
    }

    public function update(Service $service, array $data): bool
    {
        return $service->update([
            'branch_id' => $data['branch_id'] ?? null,
            'service_category_id' => $data['service_category_id'],
            'name' => $data['name'],
            'code' => $data['code'] ?? null,
            'description' => $data['description'] ?? null,
            'duration_minutes' => $data['duration_minutes'],
            'price' => $data['price'],
            'cost' => $data['cost'] ?? null,
            'commission_type' => $data['commission_type'],
            'commission_value' => $data['commission_value'],
            'status' => $data['status'],
        ]);
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}