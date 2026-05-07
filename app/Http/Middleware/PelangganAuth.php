<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelangganAuth
{
    /**
     * Redirect to pelanggan login if not authenticated as pelanggan.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('pelanggan_id')) {
            // Store the intended URL so we can redirect back after login
            session(['url.intended' => $request->url()]);
            return redirect()->route('pelanggan.login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk melanjutkan.');
        }

        return $next($request);
    }
}
