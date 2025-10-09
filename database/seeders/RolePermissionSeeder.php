<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Item management permissions
            'view items',
            'create items',
            'edit items',
            'delete items',
            
            // Category management permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Subcategory management permissions
            'view subcategories',
            'create subcategories',
            'edit subcategories',
            'delete subcategories',
            
            // Brand management permissions
            'view brands',
            'create brands',
            'edit brands',
            'delete brands',
            
            // Purchase management permissions
            'view purchases',
            'create purchases',
            'edit purchases',
            'delete purchases',
            
            // Sale management permissions
            'view sales',
            'create sales',
            'edit sales',
            'delete sales',
            
            // Stock management permissions
            'view stock',
            'create stock movements',
            'edit stock movements',
            'delete stock movements',
            
            // Loan management permissions
            'view loans',
            'create loans',
            'edit loans',
            'delete loans',
            
            // Return management permissions
            'view returns',
            'create returns',
            'edit returns',
            'delete returns',
            
            // Warranty management permissions
            'view warranties',
            'create warranties',
            'edit warranties',
            'delete warranties',
            
            // Setting management permissions
            'view settings',
            'edit settings',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Super Admin gets all permissions
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin role permissions
        $adminRole->givePermissionTo([
            'view users',
            'view items',
            'create items',
            'edit items',
            'view categories',
            'create categories',
            'edit categories',
            'view subcategories',
            'create subcategories',
            'edit subcategories',
            'view brands',
            'create brands',
            'edit brands',
            'view purchases',
            'create purchases',
            'edit purchases',
            'view sales',
            'create sales',
            'edit sales',
            'view stock',
            'create stock movements',
            'edit stock movements',
            'view loans',
            'create loans',
            'edit loans',
            'view returns',
            'create returns',
            'edit returns',
            'view warranties',
            'create warranties',
            'edit warranties',
            'view settings',
        ]);

        // User role permissions (only viewing)
        $userRole->givePermissionTo([
            'view items',
            'view categories',
            'view subcategories',
            'view brands',
            'view sales',
            'view stock',
            'view settings',
        ]);
    }
}
