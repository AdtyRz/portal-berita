<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan SEMUA modul dan aksi yang diizinkan
        $modules = [
            'posts'            => ['view', 'create', 'edit', 'delete'],
            'categories'       => ['view', 'create', 'edit', 'delete'],
            'tags'             => ['view', 'create', 'edit', 'delete'],
            'announcements'    => ['view', 'create', 'edit', 'delete'],
            'agendas'          => ['view', 'create', 'edit', 'delete'],
            'achievements'     => ['view', 'create', 'edit', 'delete'],
            'galleries'        => ['view', 'create', 'edit', 'delete'],
            'videos'           => ['view', 'create', 'edit', 'delete'],
            'documents'        => ['view', 'create', 'edit', 'delete'],
            'hero-sliders'     => ['view', 'create', 'edit', 'delete'],
            'banners'          => ['view', 'create', 'edit', 'delete'],
            'organizations'    => ['view', 'create', 'edit', 'delete'],
            'comments'         => ['view', 'approve', 'delete'],
            'contacts'         => ['view', 'delete'],
            'users'            => ['view', 'create', 'edit', 'delete'],
            'settings'         => ['view', 'edit'],
            'activity-logs'    => ['view'],
            'manage-admins'    => ['view', 'edit', 'delete'],
        ];

        // 2. Buat Permission ke Database (firstOrCreate agar tidak duplikat)
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$module}"]);
            }
        }

        // 3. Buat Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // 4. Berikan SEMUA permission ke Super Admin
        $superAdminRole->givePermissionTo(Permission::all());

        // 5. Berikan permission default ke Admin Biasa (bisa diubah nanti via UI Manage Admins)
        $adminDefaultPermissions = [
            'view posts', 'create posts', 'edit posts', 'delete posts',
            'view categories', 'create categories', 'edit categories', 'delete categories',
            'view tags', 'create tags', 'edit tags', 'delete tags',
            'view announcements', 'create announcements', 'edit announcements', 'delete announcements',
            'view agendas', 'create agendas', 'edit agendas', 'delete agendas',
            'view achievements', 'create achievements', 'edit achievements', 'delete achievements',
            'view galleries', 'create galleries', 'edit galleries', 'delete galleries',
            'view videos', 'create videos', 'edit videos', 'delete videos',
            'view documents', 'create documents', 'edit documents', 'delete documents',
            'view comments', 'approve comments', 'delete comments',
            'view contacts', 'delete contacts',
            'view settings', 'edit settings',
        ];
        
        // Sync permission agar admin punya permission default ini
        $adminRole->syncPermissions($adminDefaultPermissions);
    }
}