<?php

namespace App\Interfaces;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

interface CustomerRepositoryInterface
{
    public function getQuery(?string $search = null): Builder;

    public function create(array $data): Customer;

    public function update(Customer $customer, array $data): bool;

    public function delete(Customer $customer): bool;
}