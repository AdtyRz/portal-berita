<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Definisikan SEMUA modul dan aksi yang dibutuhkan
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
            'manage-admins'    => ['view', 'create', 'edit', 'delete'],
        ];

        // 2. Buat Permission ke Database (firstOrCreate = aman dari duplikat)
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(
                    ['name' => "{$action} {$module}", 'guard_name' => 'web']
                );
            }
        }

        // 3. Buat Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // 4. Berikan SEMUA permission ke Super Admin
        $superAdminRole->syncPermissions(Permission::all());

        // 5. PENTING: KOSONGKAN permission untuk role 'admin'
        // Agar permission 100% realtime mengikuti UI "Manage Admins"
        $adminRole->syncPermissions([]);

        echo "\n✅ Total permissions created: " . Permission::count() . "\n";
        echo "✅ Super Admin permissions: " . $superAdminRole->permissions->count() . "\n";
        echo "✅ Admin default permissions: " . $adminRole->permissions->count() . " (kosong, akan diatur via UI)\n\n";
    }

    public function down(): void
    {
        // Hapus semua permission dan role yang dibuat
        Permission::whereIn('name', [
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'view tags',
            'create tags',
            'edit tags',
            'delete tags',
            'view announcements',
            'create announcements',
            'edit announcements',
            'delete announcements',
            'view agendas',
            'create agendas',
            'edit agendas',
            'delete agendas',
            'view achievements',
            'create achievements',
            'edit achievements',
            'delete achievements',
            'view galleries',
            'create galleries',
            'edit galleries',
            'delete galleries',
            'view videos',
            'create videos',
            'edit videos',
            'delete videos',
            'view documents',
            'create documents',
            'edit documents',
            'delete documents',
            'view hero-sliders',
            'create hero-sliders',
            'edit hero-sliders',
            'delete hero-sliders',
            'view banners',
            'create banners',
            'edit banners',
            'delete banners',
            'view organizations',
            'create organizations',
            'edit organizations',
            'delete organizations',
            'view comments',
            'approve comments',
            'delete comments',
            'view contacts',
            'delete contacts',
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view settings',
            'edit settings',
            'view activity-logs',
            'view manage-admins',
            'create manage-admins',
            'edit manage-admins',
            'delete manage-admins',
        ])->delete();

        Role::whereIn('name', ['super-admin', 'admin'])->delete();
    }
};
