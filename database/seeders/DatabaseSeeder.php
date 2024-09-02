<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $manager = User::factory()->create([
            'name' => 'Manager-1',
            'employee_id' => 'EP-101',
            'position' => '',
            'email' => 'manager@mail.com',
            'password' => Hash::make('password')
        ]);

        $teammate = User::factory()->create([
            'name' => 'Teammate-1',
            'employee_id' => 'EP-201',
            'position' => 'Test Position',
            'email' => 'teammate@mail.com',
            'password' => Hash::make('password')
        ]);

        // Roll Permission seed
        $this->call(RolePermissionSeeder::class);

        // Assign user role
        $manager->assignRole('manager');
        $teammate->assignRole('teammate');



    }
}
