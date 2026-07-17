<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admin punya akses ke semuanya
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        $routeName = $request->route()->getName();

        // Dashboard dan profile SELALU bisa diakses
        if (in_array($routeName, ['admin.dashboard', 'profile.edit', 'profile.update', 'profile.destroy', 'logout'])) {
            return $next($request);
        }

        // Cek hanya untuk route admin lainnya
        if (str_starts_with($routeName, 'admin.')) {
            $parts = explode('.', $routeName);
            if (count($parts) >= 2) {
                $module = $parts[1]; // contoh: 'posts', 'categories'
                $action = $parts[2] ?? 'index';

                // Mapping action ke nama permission
                $permissionMap = [
                    'index' => "view {$module}",
                    'show' => "view {$module}",
                    'create' => "create {$module}",
                    'store' => "create {$module}",
                    'edit' => "edit {$module}",
                    'update' => "edit {$module}",
                    'destroy' => "delete {$module}",
                    'delete' => "delete {$module}",
                    'approve' => "approve {$module}",
                ];

                $requiredPermission = $permissionMap[$action] ?? "view {$module}";

                // DEBUG: Uncomment baris di bawah untuk debug
                // \Log::info("Checking permission: {$requiredPermission} for user {$user->id}");
                // \Log::info("User has permission: " . ($user->can($requiredPermission) ? 'YES' : 'NO'));

                // Jika user TIDAK punya permission, abort 403
                if (!$user->can($requiredPermission)) {
                    abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
                }
            }
        }

        return $next($request);
    }
}
