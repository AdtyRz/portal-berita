<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageAdminController extends Controller
{
    public function index()
    {
        $admins = User::role(['admin', 'super-admin'])->with('roles')->latest()->get();
        return view('admin.manage-admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::where('name', 'admin')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($item) {
            $name = str_replace(['.', '-'], ' ', $item->name);
            $words = explode(' ', $name);
            $module = count($words) > 1 ? end($words) : $words[0];
            return ucfirst($module);
        });

        return view('admin.manage-admins.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => true,
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        // Ini akan memberikan HANYA permission yang dicentang.
        // Jika tidak ada yang dicentang, user tidak punya permission langsung.
        $user->syncPermissions($request->permissions ?? []);

        // Clear cache agar realtime
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.manage-admins.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return redirect()->route('admin.manage-admins.index')->with('error', 'Super Admin profile cannot be edited.');
        }

        $roles = Role::where('name', 'admin')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($item) {
            $name = str_replace(['.', '-'], ' ', $item->name);
            $words = explode(' ', $name);
            $module = count($words) > 1 ? end($words) : $words[0];
            return ucfirst($module);
        });

        $userPermissions = $user->permissions->pluck('name')->toArray();

        return view('admin.manage-admins.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->hasRole('super-admin')) {
            return redirect()->route('admin.manage-admins.index')->with('error', 'Super Admin cannot be modified.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);
        $user->syncPermissions($request->permissions ?? []);

        // Clear cache agar realtime
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.manage-admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('super-admin')) {
            return redirect()->route('admin.manage-admins.index')
                ->with('error', 'Super Admin cannot be deleted.');
        }

        // FIX: Gunakan auth()->check() (bukan chek) untuk menghindari error undefined method
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('admin.manage-admins.index')
                ->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return redirect()->route('admin.manage-admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
}
