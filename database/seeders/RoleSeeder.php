<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $sellerRole = Role::create(['name' => 'seller']);
        $customerRole = Role::create(['name' => 'customer']);

        // Create an admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('admin');

        // Create a seller user
        $seller = User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
        ]);
        $seller->assignRole('seller');

        // Create a customer user
        $customer = User::factory()->create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
        ]);
        $customer->assignRole('customer');
    }
}
