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

        // Dashboard dan profile SELALU bisa diakses
        if (in_array($request->route()->getName(), [
            'admin.dashboard',
            'profile.edit',
            'profile.update',
            'profile.destroy',
            'logout',
            'admin.notifications.mark-read'
        ])) {
            return $next($request);
        }

        // Cek permission untuk route admin
        $routeName = $request->route()->getName();

        if (str_starts_with($routeName, 'admin.')) {
            $parts = explode('.', $routeName);
            if (count($parts) >= 2) {
                $module = $parts[1];
                $action = $parts[2] ?? 'index';

                // Mapping action ke permission
                $permissionMap = [
                    'index' => "view {$module}",
                    'show' => "view {$module}",
                    'create' => "create {$module}",
                    'store' => "create {$module}",
                    'edit' => "edit {$module}",
                    'update' => "edit {$module}",
                    'destroy' => "delete {$module}",
                    'approve' => "approve {$module}",
                ];

                $requiredPermission = $permissionMap[$action] ?? "view {$module}";

                // Cek apakah user punya permission
                if (!$user->can($requiredPermission)) {
                    // Redirect ke dashboard dengan error
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
                }
            }
        }

        return $next($request);
    }
}
