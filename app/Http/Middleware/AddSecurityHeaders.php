<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Validate Origin/Referer for POST requests to prevent CSRF
        // This is a secondary check - Laravel's CSRF token is the primary protection
        // Skip in local development
        if (config('app.env') !== 'local' && ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('PATCH') || $request->isMethod('DELETE'))) {
            $appUrl = rtrim(config('app.url'), '/');
            $origin = $request->header('Origin');
            $referer = $request->header('Referer');
            
            // Check if Origin matches our domain (only if present)
            // Some legitimate requests might not have Origin (e.g., same-origin POSTs)
            if ($origin && $origin !== 'null' && !str_starts_with($origin, $appUrl)) {
                abort(403, 'Invalid origin');
            }
            
            // Check Referer as additional validation (only if Origin is missing)
            // Be lenient - only block if Referer is clearly from a different domain
            if (!$origin && $referer) {
                $refererHost = parse_url($referer, PHP_URL_HOST);
                $appHost = parse_url($appUrl, PHP_URL_HOST);
                if ($refererHost && $appHost && $refererHost !== $appHost) {
                    abort(403, 'Invalid referer');
                }
            }
        }
        
        $response = $next($request);
        
        // Add security headers
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy to prevent XSS and CSRF
        $csp = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' data:; connect-src 'self'; frame-ancestors 'none';";
        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
}
