<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '03001234567',
            'address' => 'Karachi, Pakistan'
        ]);

        // Create Landlord
        User::create([
            'name' => 'Mr. Landlord',
            'email' => 'landlord@example.com',
            'password' => Hash::make('password'),
            'role' => 'landlord',
            'phone' => '03001234568',
            'address' => 'Lahore, Pakistan'
        ]);

        // Create Tenant
        User::create([
            'name' => 'Mr. Tenant',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password'),
            'role' => 'tenant',
            'phone' => '03001234569',
            'address' => 'Islamabad, Pakistan'
        ]);

        // Create 10 Properties
        Property::factory(10)->create();

        $this->command->info("Database seeded successfully!");
        $this->command->info("Admin: admin@example.com / password");
        $this->command->info("Landlord: landlord@example.com / password");
        $this->command->info("Tenant: tenant@example.com / password");
    }
}