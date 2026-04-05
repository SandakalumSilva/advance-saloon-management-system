<?php

namespace App\Repositories;

use App\Interfaces\ServiceInterface;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceRepository implements ServiceInterface
{
    public function getAll(): Collection
    {
        return Service::with(['branch', 'category'])
            ->branchFilter()
            ->latest()
            ->get();
    }

    public function create(array $data): Service
    {
        return DB::transaction(function () use ($data) {

            $user = Auth::user();

            $branchId = $data['branch_id'] ?? null;

            if ($user instanceof User && ! $user->isSuperAdmin()) {
                $branchId = $user->branch_id;

                $validCategory = ServiceCategory::query()
                    ->where('id', $data['service_category_id'])
                    ->where('branch_id', $user->branch_id)
                    ->exists();

                abort_unless($validCategory, 403, 'Invalid service category for this branch.');
            }

            return Service::create([
                'branch_id'           => $branchId,
                'service_category_id' => $data['service_category_id'],
                'name'                => $data['name'],
                'code'                => $data['code'] ?? null,
                'description'         => $data['description'] ?? null,
                'duration_minutes'    => $data['duration_minutes'],
                'price'               => $data['price'],
                'cost'                => $data['cost'] ?? null,
                'commission_type'     => $data['commission_type'],
                'commission_value'    => $data['commission_value'],
                'status'              => $data['status'],
            ]);
        });
    }

    public function update(Service $service, array $data): bool
    {
        return DB::transaction(function () use ($service, $data) {

            $user = Auth::user();

            if ($user instanceof User && ! $user->isSuperAdmin()) {
                $validCategory = ServiceCategory::query()
                    ->where('id', $data['service_category_id'])
                    ->where('branch_id', $user->branch_id)
                    ->exists();

                abort_unless($validCategory, 403, 'Invalid service category for this branch.');
            }

            $updateData = [
                'service_category_id' => $data['service_category_id'],
                'name'                => $data['name'],
                'code'                => $data['code'] ?? null,
                'description'         => $data['description'] ?? null,
                'duration_minutes'    => $data['duration_minutes'],
                'price'               => $data['price'],
                'cost'                => $data['cost'] ?? null,
                'commission_type'     => $data['commission_type'],
                'commission_value'    => $data['commission_value'],
                'status'              => $data['status'],
            ];

            return $service->update($updateData);
        });
    }

    public function delete(Service $service): bool
    {
        return DB::transaction(function () use ($service) {
            return $service->delete();
        });
    }
}
