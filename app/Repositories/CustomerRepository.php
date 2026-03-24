<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function getQuery(?string $search = null): Builder
    {
        return Customer::query()
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
            if (empty($data['customer_code'])) {
                $data['customer_code'] = $this->generateCustomerCode();
            }

            return Customer::create($data);
        });
    }

    public function update(Customer $customer, array $data): bool
    {
        return DB::transaction(function () use ($customer, $data) {
            return $customer->update($data);
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