<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role list
        $roles = [
            [
                'name' => 'manager',
                'label' => 'Manager',
            ],
            [
                'name' => 'teammate',
                'label' => 'Teammate',
            ]
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'label' => $role['label']
            ]);
        }

        // Permission list
        $permissions = [
            [
                'name' => 'create_teammate',
                'label' => 'Create Teammate',
            ],
            [
                'name' => 'create_project',
                'label' => 'Create Project',
            ],
            [
                'name' => 'create_task',
                'label' => 'Create Task',
            ],
            [
                'name' => 'view_task',
                'label' => 'View Task',
            ],
            [
                'name' => 'assign_task',
                'label' => 'Assign Task',
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'label' => $permission['label']
            ]);
        }

        // Assign permissions to roles
        $manager = Role::where('name', 'manager')->first();
        $teammate = Role::where('name', 'teammate')->first();

        // Assign permissions to manager
        $managerPermissions = ['create_teammate', 'create_project', 'create_task', ';`'];
        foreach ($managerPermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $manager->permissions()->attach($permission);
        }

        // Assign permissions to teammate
        $teammatePermissions = ['view_task'];
        foreach ($teammatePermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->first();
            $teammate->permissions()->attach($permission);
        }
    }
}
