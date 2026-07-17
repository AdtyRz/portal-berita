<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAdminController extends Controller
{
    public function index()
    {
        // Ambil semua user yang punya role 'admin' atau 'super-admin'
        $admins = User::role(['admin', 'super-admin'])->with('roles')->latest()->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function($item, $key){
            return explode('-', $item->name)[0] ?? 'general';
        });

        return view('admin.manage-admins.index', compact('admins', 'permissions'));
    }

        public function edit(User $user)
    {
        if ($user->hasRole('super-admin') && $user->id === auth()->id()) {
            return redirect()->route('admin.manage-admins.index')->with('error', 'You cannot edit yourself.');
        }

        $roles = Role::where('name', '!=', 'super-admin')->get();
        
        // Logika pengelompokan yang menangani format "create posts" ATAU "posts.create"
        $permissions = Permission::orderBy('name')->get()->groupBy(function($item) {
            $cleanName = str_replace(['.', '-'], ' ', $item->name);
            $words = explode(' ', $cleanName);
            $actions = ['create', 'edit', 'delete', 'view', 'update', 'manage', 'publish', 'approve'];
            
            // Jika kata pertama adalah aksi (misal: "create posts"), maka modulnya adalah kata kedua ("Posts")
            if (in_array(strtolower($words[0]), $actions) && count($words) > 1) {
                return ucfirst($words[1]); 
            }
            // Jika formatnya "posts.create", maka modulnya adalah kata pertama ("Posts")
            return ucfirst($words[0]); 
        });

        $userPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.manage-admins.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sync Role
        $user->syncRoles([$request->role]);

        // Sync Permissions (jika role bukan super-admin, kita bisa set permission granular)
        if ($request->role !== 'super-admin') {
            $user->syncPermissions($request->permissions ?? []);
        } else {
            $user->givePermissionTo(Permission::all()); // Super admin dapat semua
        }

        return redirect()->route('admin.manage-admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.manage-admins.index')->with('error', 'You cannot delete yourself.');
        }
        
        $user->delete();
        return redirect()->route('admin.manage-admins.index')->with('success', 'Admin deleted successfully.');
    }
}