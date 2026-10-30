<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
        ]);
    }
}

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::firstOrCreate(
            ['code' => 'BR-001'],
            [
                'name' => 'Main Branch',
                'phone' => '+93700000001',
                'address' => 'Kabul, Afghanistan',
                'tax_id' => 'AF-1001',
                'currency' => 'AFN',
                'is_active' => true,
            ]
        );
    }
}

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'ADMIN', 'description' => 'System administrator'],
            ['name' => 'MANAGER', 'description' => 'Branch manager'],
            ['name' => 'CASHIER', 'description' => 'Cashier'],
            ['name' => 'SERVER', 'description' => 'Waiter'],
            ['name' => 'CHEF', 'description' => 'Chef'],
        ] as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => 'Create Orders', 'key_name' => 'orders.create'],
            ['name' => 'Update Orders', 'key_name' => 'orders.update'],
            ['name' => 'View Orders', 'key_name' => 'orders.view'],
            ['name' => 'View Reports', 'key_name' => 'reports.view'],
        ] as $permission) {
            Permission::firstOrCreate(['key_name' => $permission['key_name']], $permission);
        }
    }
}

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();

        $users = [
            [
                'branch_id' => $branch->id,
                'username' => 'admin1',
                'password_hash' => bcrypt('admin123'),
                'full_name' => 'Ahmad Rahimi',
                'email' => 'admin1@restaurant.local',
                'phone' => '+93700000001',
                'role' => 'ADMIN',
                'is_active' => true,
            ],
            [
                'branch_id' => $branch->id,
                'username' => 'manager1',
                'password_hash' => bcrypt('manager123'),
                'full_name' => 'Zarif Khan',
                'email' => 'manager1@restaurant.local',
                'phone' => '+93700000002',
                'role' => 'MANAGER',
                'is_active' => true,
            ],
            [
                'branch_id' => $branch->id,
                'username' => 'cashier1',
                'password_hash' => bcrypt('cashier123'),
                'full_name' => 'Nora Shah',
                'email' => 'cashier1@restaurant.local',
                'phone' => '+93700000003',
                'role' => 'CASHIER',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(['username' => $user['username']], $user);
        }
    }
}

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $rice = \App\Models\MenuCategory::firstOrCreate(['name' => 'Rice Dishes'], ['sort_order' => 1, 'is_active' => true]);
        $grill = \App\Models\MenuCategory::firstOrCreate(['name' => 'Grill'], ['sort_order' => 2, 'is_active' => true]);

        \App\Models\MenuItem::firstOrCreate(['code' => 'MI-001'], [
            'category_id' => $rice->id,
            'name' => 'Kabuli Rice',
            'base_price' => 180.00,
            'prep_time_minutes' => 20,
            'is_available' => true,
            'is_featured' => true,
        ]);

        \App\Models\MenuItem::firstOrCreate(['code' => 'MI-002'], [
            'category_id' => $grill->id,
            'name' => 'Grilled Chicken',
            'base_price' => 260.00,
            'prep_time_minutes' => 25,
            'is_available' => true,
            'is_featured' => true,
        ]);
    }
}
