<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->roles=='admin' || auth()->user()->roles=='superadmin'|| auth()->user()->roles=='user') {
            return $next($request);
        }
        abort(403, 'Unauthorized waa khalaad.');
        
    }
}
