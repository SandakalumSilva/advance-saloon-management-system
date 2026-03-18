<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        $modules = [
            'dashboard',
            'bookings',
            'customers',
            'staff',
            'services',
            'pos',
            'products',
            'expenses',
            'reports',
            'settings'
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $module . '.' . $action,
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
