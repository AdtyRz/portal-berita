<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            // User Management
            'view-users', 'create-users', 'edit-users', 'delete-users',
            
            // Role Management (Super Admin Only)
            'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
            
            // Content Management
            'view-posts', 'create-posts', 'edit-posts', 'delete-posts', 'publish-posts',
            'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
            'view-tags', 'create-tags', 'edit-tags', 'delete-tags',
            
            // Comments
            'view-comments', 'approve-comments', 'delete-comments',
            
            // Announcements
            'view-announcements', 'create-announcements', 'edit-announcements', 'delete-announcements',
            
            // Agendas
            'view-agendas', 'create-agendas', 'edit-agendas', 'delete-agendas',
            
            // Achievements
            'view-achievements', 'create-achievements', 'edit-achievements', 'delete-achievements',
            
            // Media
            'view-galleries', 'create-galleries', 'edit-galleries', 'delete-galleries',
            'view-videos', 'create-videos', 'edit-videos', 'delete-videos',
            'view-documents', 'create-documents', 'edit-documents', 'delete-documents',
            
            // Website
            'view-profile', 'edit-profile',
            'view-hero-sliders', 'create-hero-sliders', 'edit-hero-sliders', 'delete-hero-sliders',
            'view-banners', 'create-banners', 'edit-banners', 'delete-banners',
            'view-organizations', 'create-organizations', 'edit-organizations', 'delete-organizations',
            
            // Contacts
            'view-contacts', 'delete-contacts',
            
            // Settings (Super Admin Only)
            'view-settings', 'edit-settings',
            'view-activity-logs',
            
            // Analytics
            'view-analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Super Admin - All permissions
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Most permissions except role management
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view-users', 'create-users', 'edit-users', 'delete-users',
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
            'view-organizations', 'create-organizations', 'edit-organizations', 'delete-organizations',
            'view-contacts', 'delete-contacts',
            'view-settings', 'edit-settings',
            'view-activity-logs',
            'view-analytics',
        ]);

        // Editor - Content only
        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([
            'view-posts', 'create-posts', 'edit-posts',
            'view-categories', 'create-categories', 'edit-categories',
            'view-tags', 'create-tags', 'edit-tags',
            'view-comments', 'approve-comments',
            'view-announcements', 'create-announcements', 'edit-announcements',
            'view-agendas', 'create-agendas', 'edit-agendas',
            'view-achievements', 'create-achievements', 'edit-achievements',
            'view-galleries', 'create-galleries', 'edit-galleries',
            'view-videos', 'create-videos', 'edit-videos',
            'view-documents', 'create-documents', 'edit-documents',
        ]);

        // Author - Write only
        $author = Role::create(['name' => 'author']);
        $author->givePermissionTo([
            'view-posts', 'create-posts', 'edit-posts',
            'view-categories',
            'view-tags',
        ]);
    }
}