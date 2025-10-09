<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view-dashboard',
            'manage-users', 
            'manage-items',
            'manage-categories',
            'manage-purchases',
            'manage-sales',
            'manage-loans',
            'manage-warranties',
            'view-reports',
            'manage-brands',
            'manage-subcategories',
            'manage-stock',
            'manage-settings'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Assign all permissions to super admin
        $superAdminRole->permissions()->sync(Permission::all());

        // Assign most permissions to admin except user management
        $adminPermissions = array_filter($permissions, function($perm) {
            return $perm !== 'manage-users';
        });
        $adminRole->permissions()->sync(
            Permission::whereIn('name', $adminPermissions)->pluck('id')->toArray()
        );

        // Assign basic permissions to regular user
        $userPermissions = ['view-dashboard', 'view-reports'];
        $userRole->permissions()->sync(
            Permission::whereIn('name', $userPermissions)->pluck('id')->toArray()
        );
    }
}