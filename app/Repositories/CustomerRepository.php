<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getQuery(?string $search = null): Builder
    {
        return Customer::query()
            ->branchFilter()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('customer_code', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest('id');
    }

    public function create(array $data): Customer
    {
        return DB::transaction(function () use ($data) {

            $user = Auth::user();

            if (empty($data['customer_code'])) {
                $data['customer_code'] = $this->generateCustomerCode();
            }
            $branchId = $user->branch_id;
            return Customer::create([
                'branch_id'     => $branchId,
                'customer_code' => $data['customer_code'] ?? $this->generateCustomerCode(),
                'first_name'    => $data['first_name'],
                'last_name'     => $data['last_name'] ?? null,
                'phone'         => $data['phone'] ?? null,
                'email'         => $data['email'] ?? null,
            ]);
        });
    }

    public function update(Customer $customer, array $data): bool
    {
        return DB::transaction(function () use ($customer, $data) {

            $user = Auth::user();

            $updateData = [
                'first_name' => $data['first_name'] ?? $customer->first_name,
                'last_name'  => $data['last_name'] ?? $customer->last_name,
                'phone'      => $data['phone'] ?? $customer->phone,
                'email'      => $data['email'] ?? $customer->email,
            ];

            return $customer->update($updateData);
        });
    }

    public function delete(Customer $customer): bool
    {
        return DB::transaction(function () use ($customer) {
            return (bool) $customer->delete();
        });
    }

    protected function generateCustomerCode(): string
    {
        $lastId = (Customer::withTrashed()->max('id') ?? 0) + 1;

        return 'CUST-' . str_pad($lastId, 6, '0', STR_PAD_LEFT);
    }
}
