<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PenggunaAuth
{
    /**
     * Redirect to login if not authenticated.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! session()->has('pengguna_id')) {
            return redirect()->route('autentikasi.showLogin')
                ->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // RBAC: jika role tertentu dibutuhkan
        if (! empty($roles) && ! in_array(session('pengguna_role'), $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
