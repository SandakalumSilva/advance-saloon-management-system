<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Customer::factory()->create([
        //     'customer_code' => 'CUST-000001',
        //     'first_name' => 'Walk In Customer',
        //     'last_name' => '',
        //     'phone' => '0771234567',
        //     'email' => '',
        //     'notes' => '',
        //     'status' => true,
        // ]);
        Customer::factory()->count(5)->create();
    }
}
