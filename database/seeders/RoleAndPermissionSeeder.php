<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
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
            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Role Management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',

            // Content Management
            'view-posts',
            'create-posts',
            'edit-posts',
            'delete-posts',
            'publish-posts',

            // Category Management
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // Tag Management
            'view-tags',
            'create-tags',
            'edit-tags',
            'delete-tags',

            // Comment Management
            'view-comments',
            'approve-comments',
            'delete-comments',

            // Announcement Management
            'view-announcements',
            'create-announcements',
            'edit-announcements',
            'delete-announcements',

            // Agenda Management
            'view-agendas',
            'create-agendas',
            'edit-agendas',
            'delete-agendas',

            // Achievement Management
            'view-achievements',
            'create-achievements',
            'edit-achievements',
            'delete-achievements',

            // Gallery Management
            'view-galleries',
            'create-galleries',
            'edit-galleries',
            'delete-galleries',

            // Video Management
            'view-videos',
            'create-videos',
            'edit-videos',
            'delete-videos',

            // Document Management
            'view-documents',
            'create-documents',
            'edit-documents',
            'delete-documents',

            // Website Management
            'view-profile',
            'edit-profile',
            'view-hero-sliders',
            'create-hero-sliders',
            'edit-hero-sliders',
            'delete-hero-sliders',
            'view-banners',
            'create-banners',
            'edit-banners',
            'delete-banners',

            // Settings
            'view-settings',
            'edit-settings',

            // Analytics
            'view-analytics',

            // Backup & Restore
            'backup-database',
            'restore-database',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Super Admin role with all permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Create Admin role with content management permissions
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view-posts', 'create-posts', 'edit-posts', 'delete-posts', 'publish-posts',
            'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
            'view-tags', 'create-tags', 'edit-tags', 'delete-tags',
            'view-comments', 'approve-comments', 'delete-comments',
            'view-announcements', 'create-announcements', 'edit-announcements', 'delete-announcements',
            'view-agendas', 'create-agendas', 'edit-agendas', 'delete-agendas',
            'view-achievements', 'create-achievements', 'edit-achievements', 'delete-achievements',
            'view-galleries', 'create-galleries', 'edit-galleries', 'delete-galleries',
            'view-videos', 'create-videos', 'edit-videos', 'delete-videos',
            'view-documents', 'create-documents', 'edit-documents', 'delete-documents',
            'view-profile', 'edit-profile',
            'view-hero-sliders', 'create-hero-sliders', 'edit-hero-sliders', 'delete-hero-sliders',
            'view-banners', 'create-banners', 'edit-banners', 'delete-banners',
            'view-settings', 'edit-settings',
            'view-analytics',
        ]);
    }
}
